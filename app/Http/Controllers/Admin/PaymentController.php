<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\Settings;
use App\Models\Subscriptions;
use App\Models\Transactions;
use App\Models\User;
use App\Notifications\OfflineVendorSubscriptionNotification;
use App\Services\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $subscriptionService;

    public function __construct(Subscription $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscription(Request $request)
    {
        $vendor = auth()->user();
        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }
        $subscription = $vendor->subscriptionData();

        if (isset($current_plans->plan_id) && $current_plans->plan_id == 0) {
            $subscription = "trial";
        }

        $plans = Plans::where('status', 'active')->get();
        return view("admin.vendor_subscription.index", compact('plans', 'vendor', 'subscription'));
    }


    public function paymentHistory(Request $request)
    {
        $vendor = auth()->user();
        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }

        $transactions = Transactions::where('user_id', $vendor->id)->orderBy('created_at', 'desc')->get();
        return view("admin.vendor_subscription.payment_history", compact('transactions'));
    }

    public function planDetails(Plans $plan)
    {
        $vendor = auth()->user();
        if (empty($vendor->email_verified_at)) {
            request()->session()->flash('Error', __('system.fields.email_unverified'));
            return redirect()->back();
        }

        if (empty($vendor->address) || empty($vendor->city) || empty($vendor->zip) || empty($vendor->country)) {
            request()->session()->flash('Error', __('system.dashboard.missing_address'));
            return redirect()->route('admin.profile.edit');
        }

        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }
        $current_plans = auth()->user()->subscriptionData() ? auth()->user()->subscriptionData()->plan_id : 0;

        $current_plan_data = auth()->user()->subscriptionData();
        if ($current_plan_data != null) {
            if ($current_plan_data->subscription_id != null && in_array($current_plan_data->type, array('monthly', 'weekly', 'yearly')) && $current_plan_data->status == 'approved' && $current_plan_data->expiry_date > date('Y-m-d H:i:s')) {
                return redirect()->back()->with('Error', __('system.plans.active_subscription_exist'));
            }
        }

        if ($current_plans == $plan->plan_id) {
            return redirect('subscription');
        }

        return view("admin.vendor_subscription.details", compact('plan'));
    }

    public function process(Request $request, Plans $plan)
    {
        $authUser = auth()->user();
        $payment_type = $request->payment_type;

        $extra_validate = [];
        if ($request->show_address) {
            $extra_validate = ["city" => 'required', "state" => 'required', "country" => 'required', "zip" => 'required', "address" => 'required',];
        }

        $attributes = $request->validate(['payment_type' => 'in:stripe,paypal,offline',] + $extra_validate);

        $checkExistingPlan = auth()->user()->load([
            'user_plans' => function ($userPlans)
            {
                $userPlans->where('payment_method', 'offline')->where('status', 'pending');
            }
        ]);

        if (auth()->user()->subscriptionData() && auth()->user()->subscriptionData()->plan_id == $plan->plan_id) {
            return back()->with('Error', trans('system.plans.already_registered_plan'));
        }

        if (count($checkExistingPlan->user_plans) > 0 && $payment_type == 'offline') {
            return back()->with('Error', trans('system.plans.wait_until_approved_or_rejected'));
        }

        try {

            $expiredDate = null;
            $paypal_plan_type = null;
            if ($plan->type == 'weekly') {
                $expiredDate = now()->addWeek();
                $paypal_plan_type = "WEEK";

            } else if ($plan->type == 'monthly') {
                $expiredDate = now()->addMonth();
                $paypal_plan_type = "MONTH";

            } else if ($plan->type == 'yearly') {
                $expiredDate = now()->addYear();
                $paypal_plan_type = "YEAR";

            } else if ($plan->type == 'day') {
                $expiredDate = now()->addDay();
                $paypal_plan_type = "DAY";
            }

            if ($request->show_address) {
                unset($attributes['payment_type']);
                $authUser->update($attributes);
            }

            //Create initial subscription entry
            $userPlan = $this->subscriptionService->createSubscription($plan, $expiredDate, $payment_type);

            if ($plan->amount <= 0) {

                //Update subscription
                Subscriptions::where(['user_id' => $userPlan->user_id, 'is_current' => 'yes'])->update(['is_current' => 'no']);

                $userPlan->status = 'approved';
                $userPlan->is_current = 'yes';
                $userPlan->transaction_id = '0';
                $userPlan->save();

                return redirect('subscription')->with('Success', trans('system.plans.play_change_success'));
            }

            if ($payment_type == 'paypal') {
                if ($plan->type == "onetime") {
                    $order = (new PayPalController($this->subscriptionService))->createOrder(
                        $userPlan->amount,
                        route('admin.paypal.onetime.success'),
                        route('admin.paypal.onetime.cancel'),
                        $userPlan
                    );
                    return redirect($order['links'][1]['href']); // approve link
                } else {
                    return (new PayPalController($this->subscriptionService))->createPaypalSubscription($paypal_plan_type, $authUser, $plan, $userPlan->id);
                }

            } else if ($payment_type == 'stripe') {

                if ($userPlan->type == 'onetime') {
                    return (new StripeController($this->subscriptionService))->onetimePayment($plan, $userPlan);
                } else {
                    return (new StripeController($this->subscriptionService))->subscriptionPayment($plan, $userPlan);
                }

            } else if ($payment_type == 'offline') {

                $userPlan->transaction_id = $request->transaction_id;
                $userPlan->details = $request->reference;
                $userPlan->save();

                $adminUser = User::where('user_type', User::USER_TYPE_ADMIN)->first();
                if ($adminUser != null) {

                    $paymentDetails = ['vendor_name' => $authUser->name, 'payment_amount' => $userPlan->amount, 'payment_method' => 'Offline', 'payment_reference' => $request->reference, 'admin_name' => $adminUser->first_name];

                    $adminUser->notify(new OfflineVendorSubscriptionNotification($paymentDetails));
                }
                return redirect('subscription')->with('Success', trans('system.plans.request_received'));

            }
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect('subscription')->with(['Error' => $ex->getMessage()]);
        }
    }

    public function subscriptionCancel(Subscriptions $subscription)
    {
        try {

            if ($subscription == null) {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }

            $userPlan = Subscriptions::where('id', $subscription->id)->where('is_current', 'yes')->first();

            if ($userPlan == null) {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }

            //Cancel Subscription
            if ($userPlan->payment_method == "paypal") {
                return (new PayPalController($this->subscriptionService))->cancelSubscription($userPlan->subscription_id);

            } elseif ($userPlan->payment_method == "stripe") {
                return (new StripeController($this->subscriptionService))->subscriptionCancel($userPlan);

            }

        } catch (\Exception $exception) {
            return redirect('subscription')->with(['Error' => $exception->getMessage()]);
        }
    }

    public function subscriptionManage(Subscriptions $subscription)
    {
        try {

            $authUser = auth()->user();

            if ($authUser->user_type != User::USER_TYPE_VENDOR) {
                return redirect('home');
            }

            $stripe_secret_key = config('stripe.stripe_secret_key');

            if (!$stripe_secret_key || $stripe_secret_key == "") {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            if ($subscription->subscription_id == null) {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }


            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            $stripe_data = $stripe->billingPortal->sessions->create(['customer' => $authUser->stripe_customer_id, 'return_url' => url('home'),]);
            if (isset($stripe_data->url)) {
                return redirect()->to($stripe_data->url);
            }

            return redirect('subscription');
        } catch (\Exception $exception) {
            return redirect('subscription')->with(['Error' => $exception->getMessage()]);
        }
    }
}
