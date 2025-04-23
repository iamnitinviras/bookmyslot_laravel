<?php
// app/Services/PayPalService.php

namespace App\Services;

use App\Models\Subscriptions;
use App\Models\Transactions;
use App\Notifications\OnetimePaymentNotification;
use GuzzleHttp\Client;

class Subscription
{

    public function __construct()
    {

    }

    public function createSubscription($plan, $expiredDate, $payment_type)
    {
        // Create initial subscription entry
        $userPlan = new Subscriptions();
        $userPlan->user_id = auth()->id();
        $userPlan->plan_id = $plan->plan_id;
        $userPlan->start_date = now();
        $userPlan->expiry_date = $expiredDate;
        $userPlan->is_current = 'no';
        $userPlan->payment_method = $payment_type;
        $userPlan->amount = $plan->amount;
        $userPlan->type = $plan->type;
        $userPlan->branch_limit = $plan->branch_limit;
        $userPlan->staff_limit = $plan->staff_limit;
        $userPlan->staff_unlimited = $plan->staff_unlimited;
        $userPlan->branch_unlimited = $plan->branch_unlimited;
        $userPlan->status = 'pending';
        $userPlan->save();

        return $userPlan;
    }

    protected function saveTransaction($user_plan, $transaction_id, $user_data, $plan_data)
    {

        //Save transaction details
        Transactions::updateOrCreate(['transaction_id' => $transaction_id], [
            'user_id' => $user_plan->user_id,
            'plan_id' => $user_plan->plan_id,
            'subscription_id' => $user_plan->id,
            'amount' => $user_plan->amount,
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


    public function chargeSucceeded($transaction_id, $sub_id)
    {
        $transaction_data = Transactions::where('transaction_id', $transaction_id)->first();

        if ($transaction_data == null) {

            $user_plan = Subscriptions::find($sub_id);

            if ($user_plan != null) {

                //Make current subscription active
                Subscriptions::where([
                    'user_id' => $user_plan->user_id,
                    'is_current' => 'yes'
                ])->update(['is_current' => 'no']);


                //Update Subscription
                Subscriptions::where('id', $user_plan->id)->update([
                    'status' => 'approved',
                    'is_current' => 'yes',
                    'transaction_id' => $transaction_id,
                    'subscription_id' => null,
                ]);

                $current_subscription = Subscriptions::find($user_plan->id);

                //Save Transaction
                $this->saveTransaction($current_subscription, $transaction_id, $user_plan->user, $user_plan->plan, $event->type);

            }
        }

    }


    // This function will check when invoice paid
    public function invoicePaid($user_plan, $subscription_id, $paymentId)
    {
        //Make current subscription active
        Subscriptions::where([
            'user_id' => $user_plan->user_id,
            'is_current' => 'yes'
        ])->update(['is_current' => 'no']);

        //Update Subscription
        Subscriptions::where('id', $user_plan->id)->update([
            'status' => 'approved',
            'is_current' => 'yes',
            'subscription_id' => $subscription_id,
        ]);


        //Add Transaction
        $transaction_count = Transactions::where('user_id', $user_plan->user_id)->where('plan_id', $user_plan->plan_id)->where('subscription_id', $user_plan->id)->count();

        if ($transaction_count > 0) {

            $user_plan->transaction_id = $paymentId;

            if ($user_plan->type == 'weekly') {
                $user_plan->expiry_date = now()->addWeek();
                $user_plan->save();

            } else if ($user_plan->type == 'monthly') {
                $user_plan->expiry_date = now()->addMonth();
                $user_plan->save();

            } else if ($user_plan->type == 'yearly') {
                $user_plan->expiry_date = now()->addYear();
                $user_plan->save();

            } else if ($user_plan->type == 'day') {
                $user_plan->expiry_date = now()->addDay();
                $user_plan->save();

            }
        }

        $current_subscription = Subscriptions::find($user_plan->id);

        //Save Transaction
        $this->saveTransaction($current_subscription, $paymentId, $current_subscription->user, $current_subscription->plan);
    }

}
