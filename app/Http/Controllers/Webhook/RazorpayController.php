<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\WebhookData;
use App\Services\Subscription;
use Illuminate\Http\Request;
use Log;

class RazorpayController extends Controller
{
    protected $subscriptionService;

    public function __construct(Subscription $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }
    public function index(Request $request)
    {
        // Log the payload for debugging
        Log::info('Razorpay Webhook Received:', $request->all());

        $eventType = $request->get('event');
        $resource = $request->get('payload');

        switch ($eventType) {
            case 'subscription.activated':
                if (isset($resource['subscription']['entity'])) {

                    $id = $resource['subscription']['entity']['notes']['notes_key_1'];
                    $razorpay_subscription_id = $resource['subscription']['entity']['id'];
                    $payment_id = $resource['payment']['entity']['id'];

                    $user_plan = Subscriptions::find($id);

                    if (isset($user_plan) && $user_plan != null) {
                        $this->subscriptionService->invoicePaid($user_plan, $razorpay_subscription_id, $payment_id);
                    }
                }

                break;

            case 'order.paid':
                if (isset($resource['order']['entity'])) {
                    $subscription_id = $resource['order']['entity']['receipt'];
                    $payment_id = $resource['payment']['entity']['id'];
                    $user_plan = Subscriptions::find($subscription_id);

                    if (isset($user_plan) && $user_plan != null && $user_plan->is_processed == false) {
                        $this->subscriptionService->chargeSucceeded($payment_id, $subscription_id);
                    }
                }
                break;
            case 'subscription.charged':
                if (isset($resource['subscription']['entity'])) {

                    $id = $resource['subscription']['entity']['notes']['notes_key_1'];

                    $razorpay_subscription_id = $resource['subscription']['entity']['id'];
                    $payment_id = $resource['payment']['entity']['id'];

                    $user_plan = Subscriptions::find($id);
                    if (isset($user_plan) && $user_plan != null) {
                        $this->subscriptionService->invoicePaid($user_plan, $razorpay_subscription_id, $payment_id);
                    }
                }
                break;

            default:
                Log::warning('Razorpay PayPal Webhook Event: ' . $eventType);
        }

        return response()->json(['status' => 'received'], 200);
    }
}
