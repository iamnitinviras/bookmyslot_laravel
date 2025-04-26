<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Services\Subscription;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{

    protected $subscriptionService;

    public function __construct(Subscription $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    // Create Subscription
    public function createRazorpaySubscription($razorpay_plan_type, $user, $plan, $subscriptionId)
    {
        $subscription = $this->createSubscription(
            $razorpay_plan_type,
            $user,
            $plan,
            $subscriptionId,
            route('admin.razorpay.success'),
            route('admin.razorpay.cancel')
        );

        return redirect($subscription->short_url);
    }

    // Success Route
    public function success(Request $request)
    {
        try {
            $result = $this->getSubscription($request->subscription_id);
            if (isset($result) && count($result) > 0) {

                $custom = json_decode($result['custom_id'], true);
                $subscription_id = $custom['subscription_id'] ?? null;

                $subscription = Subscriptions::find($subscription_id);
                if ($subscription == null) {
                    throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
                }

                $this->subscriptionService->invoicePaid($subscription, $result['id'], time());
                return redirect('home')->with('Success', trans('system.plans.play_change_success'));
            } else {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }
        } catch (\Exception $exception) {
            return redirect('subscription')->with(['Error' => $exception->getMessage()]);
        }
    }

    public function cancel(Request $request)
    {
        try {
            $result = $this->getSubscription($request->subscription_id);
            if (isset($result) && count($result) > 0) {
                $subscription = Subscriptions::find($result['custom_id']);
                if ($subscription == null) {
                    throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
                }

                $subscription->delete();
                return redirect('subscription')->with('Error', trans('system.plans.invalid_payment'));

            } else {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }
        } catch (\Exception $exception) {
            return redirect('subscription')->with(['Error' => $exception->getMessage()]);
        }
    }

    public function createPlan($razorpay_plan_type, $plan)
    {
        $title = $plan->title;
        $amount = $plan->amount;
        $description = $plan->description;

        //Get ProductID
        $razorpay_plan_id = $plan->razorpay_plan_id;
        // dd($razorpay_plan_type);

        if ($plan->razorpay_plan_id == null) {

            $api = new Api(config('razorpay.key_id'), config('razorpay.secret'));
            $response = $api->plan->create(array(
                'period' => $razorpay_plan_type,
                'interval' => 1,
                'item' => array(
                    'name' => $title,
                    'description' => $description,
                    'amount' => $amount * 100,
                    'currency' => config('razorpay.currency')
                )
            ));

            $razorpay_plan_id = $response->id ?? null;
            $plan->razorpay_plan_id = $razorpay_plan_id;
            $plan->save();
        }
        return $razorpay_plan_id;
    }

    // Create a Subscription
    public function createSubscription($razorpay_plan_type, $user, $plan, $subscriptionId, $returnUrl, $cancelUrl)
    {
        $planId = $this->createPlan($razorpay_plan_type, $plan);
        $api = new Api(config('razorpay.key_id'), config('razorpay.secret'));
        $response = $api->subscription->create(
            array(
                "plan_id" => $planId,
                "total_count" => $plan->amount,
                "quantity" => 1,
                "customer_notify" => 1,
                "notify_info" => array(
                    "notify_phone" => $user->phone_number,
                    "notify_email" => $user->email
                )
            )
        );
        return $response; // approve link
    }

    // Cancel Subscription
    public function cancelSubscription($subscriptionId)
    {
        $api = new Api(config('razorpay.key_id'), config('razorpay.secret'));
        $options = array(
            'subscriptionId' => $subscriptionId,
            'cancel_at_cycle_end' => true,
        );
        $api->subscription->fetch($subscriptionId)->cancel($options);

        $userPlan = Subscriptions::where('subscription_id', $subscriptionId)->first();
        if ($userPlan != null) {
            $userPlan->subscription_id = null;
            $userPlan->status = 'canceled';
            $userPlan->save();
        }

        return redirect()->back()->with('Success', trans('system.plans.cancel_subscription_success'));
    }

    public function createOrder($authUser, $amount, $returnUrl, $user_plan)
    {
        $api = new Api(config('razorpay.key_id'), config('razorpay.secret'));
        $response = $api->paymentLink->create(array(
            'amount' => $amount * 100,
            'currency' => config('razorpay.currency'),
            'accept_partial' => false,
            'reference_id' => $user_plan->id,
            'description' => 'For XYZ purpose',
            'customer' => array(
                'name' => $authUser->first_name . " " . $authUser->last_name,
                'email' => $authUser->email,
                'contact' => $authUser->phone_number
            ),
            'notify' => array('sms' => true, 'email' => true),
            'reminder_enable' => true,
            'callback_url' => $returnUrl,
            'callback_method' => 'get'
        ));
        return $response;
    }

    public function onetimeSuccess(Request $request)
    {
        $razorpay_payment_id = $request->razorpay_payment_id;
        $reference_id = $request->razorpay_payment_link_reference_id;
        try {

            $user_plan = Subscriptions::find($reference_id);
            if (isset($user_plan) && $user_plan != null && $user_plan->is_processed == false) {
                $this->subscriptionService->chargeSucceeded($razorpay_payment_id, $reference_id);
            }
            return redirect('home')->with('Success', trans('system.plans.play_change_success'));
        } catch (\Exception $ex) {
            return redirect('subscription')->with(['Error' => $ex->getMessage()]);
        }
    }
}
