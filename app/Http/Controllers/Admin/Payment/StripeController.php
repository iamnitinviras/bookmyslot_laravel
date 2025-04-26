<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\Subscriptions;
use App\Models\Transactions;
use App\Notifications\OnetimePaymentNotification;
use App\Services\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{

    protected $subscriptionService;

    public function __construct(Subscription $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }
    public function onetimePayment($plan, $userPlan)
    {
        $authUser = auth()->user();

        try {

            $currency = config('custom.currency');
            $stripe_secret_key = config('stripe.stripe_secret_key');

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            //Subscription
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            \Stripe\Stripe::setApiKey($stripe_secret_key);

            $metaDatas = [
                'sub_id' => $userPlan->id,
                'user_id' => $userPlan->user_id,
                'plan_id' => $plan->plan_id,
                'amount' => $plan->amount,
                'payment_type' => 'onetime',
            ];

            //Product
            $stripe_plan_id = $plan->stripe_plan_id;
            if ($plan->stripe_plan_id == null) {

                $product = $stripe->products->create([
                    'name' => $plan->local_title,
                ]);

                $stripe_plan_id = $product->id;
                $plan->stripe_plan_id = $product->id;
                $plan->save();
            }

            //Price
            $price_array = [
                'unit_amount' => $plan->amount * 100,
                'currency' => $currency,
                'product' => $stripe_plan_id
            ];

            $price = $stripe->prices->create($price_array);

            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [
                    [
                        'price' => $price->id,
                        'quantity' => 1
                    ]
                ],
                'mode' => 'payment',
                'success_url' => url('stripe/onetime-success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('stripe/onetime-cancelled?subscription=' . $userPlan->id),
                'client_reference_id' => $userPlan->id,
                'customer_email' => $authUser->email,
                'metadata' => $metaDatas,
                'payment_intent_data' => [
                    'metadata' => $metaDatas
                ]
            ]);
            return redirect()->to($checkout_session->url);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }


    public function onetimeSuccess(Request $request)
    {
        $session_id = ($request->session_id);
        try {
            $authUser = auth()->user();
            $stripe_secret_key = config('stripe.stripe_secret_key');

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            \Stripe\Stripe::setApiKey($stripe_secret_key);

            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);


            $client_reference_id = ($checkout_session->client_reference_id);
            $payment_intent = ($checkout_session->payment_intent);

            $payment_intent_data = $stripe->paymentIntents->retrieve(
                $payment_intent,
                []
            );

            if (isset($payment_intent_data->charges) && isset($payment_intent_data->charges->data[0])) {
                $transaction_id = ($payment_intent_data->charges->data[0]->balance_transaction);
            } else {
                $transaction_id = time();
            }

            //save stripe customer id in user table
            $authUser->stripe_customer_id = $checkout_session->customer;
            $authUser->save();

            //Make current subscription active
            $user_plan = Subscriptions::find($client_reference_id);

            if (isset($user_plan) && $user_plan != null && $user_plan->is_processed == false) {
                $this->subscriptionService->chargeSucceeded($transaction_id, $user_plan->id);
            }

            return redirect('home')->with('Success', trans('system.plans.play_change_success'));
        } catch (\Exception $exception) {
            return redirect('home')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }
    }

    public function onetimeCancelled(Request $request)
    {
        $subscription = Subscriptions::find($request->subscription);
        $subscription->delete();

        return redirect('home')->with('Error', trans('system.messages.operation_canceled'));
    }

    public function subscriptionPayment($plan, $userPlan)
    {

        $currency = config('stripe.currency');
        try {

            $authUser = auth()->user();
            $stripe_secret_key = config('stripe.stripe_secret_key');

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            if ($plan->type == 'weekly') {
                $recurring_type = 'week';
            } else if ($plan->type == 'monthly') {
                $recurring_type = 'month';
            } else if ($plan->type == 'yearly') {
                $recurring_type = 'year';
            } else if ($plan->type == 'day') {
                $recurring_type = 'day';
            } else {
                $recurring_type = '';
            }

            //Subscription
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            \Stripe\Stripe::setApiKey($stripe_secret_key);

            //Customer

            if (!$recurring_type || $recurring_type == "" || $recurring_type == null) {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            //Product
            $stripe_plan_id = $plan->stripe_plan_id;

            if ($plan->stripe_plan_id == null) {
                $product = $stripe->products->create([
                    'name' => $plan->title,
                ]);

                $stripe_plan_id = $product->id;
                $plan->stripe_plan_id = $product->id;
                $plan->save();
            }

            //Price
            $price_array = [
                'unit_amount' => $plan->amount * 100,
                'currency' => $currency,
                'product' => $stripe_plan_id,
            ];

            $metaDatas = [
                'sub_id' => $userPlan->id,
                'user_id' => $userPlan->user_id,
                'plan_id' => $plan->plan_id,
                'amount' => $plan->amount,
            ];

            $price_array['recurring'] = ['interval' => $recurring_type];
            $price = $stripe->prices->create($price_array);

            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [
                    [
                        'price' => $price->id,
                        'quantity' => 1
                    ]
                ],
                'mode' => 'subscription',
                'success_url' => url('stripe/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('stripe/onetime-cancelled?subscription=' . $userPlan->id),
                'client_reference_id' => $userPlan->id,
                'customer_email' => $authUser->email,
                'metadata' => $metaDatas,
                'subscription_data' => [
                    'metadata' => $metaDatas
                ]
            ]);

            return redirect()->to($checkout_session->url);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            throw new \Exception($e->getMessage());
        }
    }


    public function processSuccess(Request $request)
    {
        $session_id = ($request->session_id);
        try {
            $authUser = auth()->user();
            $stripe_secret_key = config('stripe.stripe_secret_key');

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            \Stripe\Stripe::setApiKey($stripe_secret_key);
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);


            $client_reference_id = ($checkout_session->client_reference_id);
            $subscription_id = ($checkout_session->subscription);

            //save stripe customer id in user table
            $authUser->stripe_customer_id = $checkout_session->customer;
            $authUser->save();

            //Make current subscription active
            $user_plan = Subscriptions::find($client_reference_id);

            if (isset($user_plan) && $user_plan != null && $user_plan->is_processed == false) {
                $this->subscriptionService->invoicePaid($user_plan, $subscription_id, time());
            }

            return redirect('home')->with('Success', trans('system.plans.play_change_success'));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect('home')->withErrors(['msg' => trans('system.plans.invalid_payment')]);
        }
    }

    public function processCancelled(Request $request)
    {
        $subscription = Subscriptions::find($request->subscription);
        $subscription->delete();

        return redirect('home')->with('Error', trans('system.messages.operation_canceled'));
    }

    public function subscriptionCancel($userPlan)
    {
        $stripe_secret_key = config('stripe.stripe_secret_key');

        if (!$stripe_secret_key || $stripe_secret_key == "") {
            throw new \Exception(trans('system.plans.invalid_payment'));
        }

        $stripe = new \Stripe\StripeClient($stripe_secret_key);
        $result = $stripe->subscriptions->cancel(
            $userPlan->subscription_id,
            []
        );
        if ($result->status == 'canceled') {
            $userPlan->subscription_id = null;
            $userPlan->status = 'canceled';
            $userPlan->save();
            return redirect()->back()->with('Success', trans('system.plans.cancel_subscription_success'));
        } else {
            throw new \Exception(trans('system.plans.invalid_payment'));
        }
    }
}
