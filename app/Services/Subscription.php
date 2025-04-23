<?php
// app/Services/PayPalService.php

namespace App\Services;

use App\Models\Subscriptions;
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

}
