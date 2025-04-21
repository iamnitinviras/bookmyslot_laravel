<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayPalService;


class PayPalController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    // Create a Subscription Plan
    public function createPlan()
    {
        $plan = $this->payPalService->createPlan('Premium Plan', '10.00');
        return response()->json($plan);
    }

    // Create Subscription
    public function createSubscription(Request $request)
    {
        $subscription = $this->payPalService->createSubscription(
            $request->plan_id,
            route('paypal.success'),
            route('paypal.cancel')
        );

        return redirect($subscription['links'][0]['href']);
    }

    // Success Route
    public function success(Request $request)
    {
        return response()->json(['message' => 'Subscription successful!', 'data' => $request->all()]);
    }

    // Cancel Route
    public function cancel()
    {
        return response()->json(['message' => 'Subscription canceled.']);
    }

    // Get Subscription Details
    public function getSubscription($subscriptionId)
    {
        $subscription = $this->payPalService->getSubscription($subscriptionId);
        return response()->json($subscription);
    }

    // Cancel Subscription
    public function cancelSubscription($subscriptionId)
    {
        $this->payPalService->cancelSubscription($subscriptionId);
        return response()->json(['message' => 'Subscription canceled successfully']);
    }
}
