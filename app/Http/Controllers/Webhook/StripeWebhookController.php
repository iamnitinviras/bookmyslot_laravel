<?php

namespace App\Http\Controllers\Webhook;

use App\Models\Plans;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Transactions;
use App\Models\User;
use App\Models\WebhookData;
use App\Notifications\OnetimePaymentNotification;
use App\Services\Subscription;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{


    protected $subscriptionService;

    public function __construct(Subscription $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function stripe()
    {
        $stripe_data = Settings::where('title', 'stripe')->first();
        $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();

        $stripe_secret_key = config('stripe.stripe_secret_key');

        \Stripe\Stripe::setApiKey($stripe_secret_key);


        $payload = @file_get_contents('php://input');
        $event = null;

        try {

            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );


            WebhookData::create([
                'type' => $event->type,
                'response' => $event,
            ]);

            switch ($event->type) {
                case 'invoice.payment_succeeded':
                    // case 'invoice.paid':
                    $paymentId = $event->data->object->id;
                    if (isset($event->data->object->lines->data[0])) {
                        $subscription_data = $event->data->object->lines->data[0]->metadata;
                        $subscription_id = $event->data->object->lines->data[0]->parent->subscription_item_details->subscription;

                        $user_plan = Subscriptions::find($subscription_data->sub_id);

                        if ($user_plan != null) {
                            $this->subscriptionService->invoicePaid($user_plan, $subscription_id, $paymentId);
                        }
                    }

                    break;
                case 'checkout.session.completed':

                    $sub_id = $event->data->object->metadata->sub_id;

                    if (isset($event->data->object->mode) && $event->data->object->mode == 'payment') {
                        if (isset($sub_id) && $sub_id != null) {
                            $this->subscriptionService->chargeSucceeded(time(), $sub_id);
                        }
                    }

                    break;
                default:
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    protected function saveTransaction($user_plan, $transaction_id, $user_data, $plan_data, $event_type)
    {

        //Save transaction details
        Transactions::updateOrCreate(['transaction_id' => $transaction_id], [
            'user_id' => $user_plan->user_id,
            'plan_id' => $user_plan->plan_id,
            'subscription_id' => $user_plan->id,
            'amount' => $user_plan->amount,
            'details' => $event_type,
            'payment_response' => $user_plan->amount
        ]);

        //Send email
        $emailAttributes = [
            'vendor_name' => $user_data->name,
            'payment_amount' => $plan_data->amount,
            'payment_method' => 'Stripe',
            'payment_date' => now(),
            'plan_name' => $plan_data->title,
            'payment_type' => $plan_data->type,
            'transaction_id' => $transaction_id,
        ];
        $user_data->notify(new OnetimePaymentNotification($emailAttributes));
    }
}
