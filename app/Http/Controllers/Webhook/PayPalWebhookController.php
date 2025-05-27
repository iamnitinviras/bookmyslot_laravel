<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\WebhookData;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Log;

class PayPalWebhookController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }
    public function index(Request $request)
    {
        // Log the payload for debugging
        Log::info('PayPal Webhook Received:', $request->all());

        $eventType = $request->get('event_type');
        $resource = $request->get('resource');

        WebhookData::create([
            'type' => $eventType,
            'response' => $resource,
            'webhook_from' => 'razorpay'
        ]);

        switch ($eventType) {
            case 'CHECKOUT.ORDER.APPROVED':
                $custom = json_decode($resource['purchase_units'][0]['custom_id'], true);
                $captures_id = $resource['purchase_units'][0]['payments']['captures'][0]['id'];
                $subscription_id = $custom['subscription_id'] ?? null;

                $user_plan = Subscriptions::find($subscription_id);
                if (isset($user_plan) && $user_plan != null && $user_plan->is_processed == false) {
                    $this->subscriptionService->chargeSucceeded($captures_id, $subscription_id);
                }
                break;

            case 'BILLING.SUBSCRIPTION.ACTIVATED':

                $custom = json_decode($resource['custom_id'], true);
                $subscription_id = $custom['subscription_id'] ?? null;
                $paypal_subscription_id = $resource['id'];

                $user_plan = Subscriptions::find($subscription_id);

                if (isset($user_plan) && $user_plan != null) {
                    $this->subscriptionService->invoicePaid($user_plan, $paypal_subscription_id, time());
                }
                break;

            case 'BILLING.SUBSCRIPTION.CANCELLED':
                // Handle subscription canceled
                Log::info('Subscription Cancelled: ' . $resource['id']);
                // Mark subscription as cancelled in DB
                break;

            case 'PAYMENT.SALE.COMPLETED':
                $custom = json_decode($resource['custom_id'], true);
                $subscription_id = $custom['subscription_id'] ?? null;
                $paypal_subscription_id = $resource['id'];

                $user_plan = Subscriptions::find($subscription_id);

                if (isset($user_plan) && $user_plan != null) {
                    $this->subscriptionService->invoicePaid($user_plan, $paypal_subscription_id, time());
                }
                Log::info('Payment Completed for Subscription: ' . $resource['billing_agreement_id']);
                break;

            case 'BILLING.SUBSCRIPTION.SUSPENDED':
                // Handle suspension
                Log::info('Subscription Suspended: ' . $resource['id']);
                break;

            case 'BILLING.SUBSCRIPTION.EXPIRED':
                // Handle expiration
                Log::info('Subscription Expired: ' . $resource['id']);
                break;

            default:
                Log::warning('Unhandled PayPal Webhook Event: ' . $eventType);
        }

        return response()->json(['status' => 'received'], 200);
    }
}
