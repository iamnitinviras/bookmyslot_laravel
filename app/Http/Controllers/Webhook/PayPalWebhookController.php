<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class PayPalWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log the payload for debugging
        Log::info('PayPal Webhook Received:', $request->all());

        $eventType = $request->get('event_type');
        $resource = $request->get('resource');

        switch ($eventType) {
            case 'BILLING.SUBSCRIPTION.CREATED':
                // Handle subscription created
                Log::info('Subscription Created: ' . $resource['id']);
                // Store in DB if needed
                break;

            case 'BILLING.SUBSCRIPTION.ACTIVATED':
                // Handle subscription activated
                Log::info('Subscription Activated: ' . $resource['id']);
                break;

            case 'BILLING.SUBSCRIPTION.CANCELLED':
                // Handle subscription canceled
                Log::info('Subscription Cancelled: ' . $resource['id']);
                // Mark subscription as cancelled in DB
                break;

            case 'PAYMENT.SALE.COMPLETED':
                // Payment was successful
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
