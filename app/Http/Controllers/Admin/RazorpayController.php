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
                "total_count" => 500,
                "quantity" => 1,
                //"start_at" => strtotime(now()),
                //"expire_by" => strtotime(date('Y-m-d H:i:s', strtotime('+1 month'))),
                "customer_notify" => 1,
                "notify_info" => array(
                    "notify_phone" => $user->phone_number,
                    "notify_email" => $user->email
                )
            )
        );
        return $response; // approve link
    }

    // Get Subscription Details
    public function getSubscription($subscriptionId)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->get("{$this->baseUrl}/v1/billing/subscriptions/$subscriptionId", [
            'headers' => ['Authorization' => "Bearer $accessToken"],
        ]);

        return json_decode($response->getBody(), true);
    }

    // Cancel Subscription
    public function cancelSubscription($subscriptionId)
    {
        $accessToken = $this->getAccessToken();

        $this->client->post("{$this->baseUrl}/v1/billing/subscriptions/$subscriptionId/cancel", [
            'headers' => ['Authorization' => "Bearer $accessToken", 'Content-Type' => 'application/json'],
            'json' => ['reason' => 'User requested cancellation.']
        ]);

        $userPlan = Subscriptions::where('subscription_id', $subscriptionId)->first();
        if ($userPlan != null) {
            $userPlan->subscription_id = null;
            $userPlan->status = 'canceled';
            $userPlan->save();
        }

        return redirect()->back()->with('Success', trans('system.plans.cancel_subscription_success'));
    }

    public function createProduct($name, $description = 'Subscription Product')
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post("{$this->baseUrl}/v1/catalogs/products", [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'name' => $name,
                'description' => $description,
                'type' => 'SERVICE',
                'category' => 'SOFTWARE', // Change based on your product
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function createOrder($amount, $returnUrl, $cancelUrl, $user_plan)
    {
        $accessToken = $this->getAccessToken();
        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('paypal.currency'),
                        'value' => $amount
                    ],
                    'custom_id' => json_encode([
                        'subscription_id' => $user_plan->id,
                        'type' => 'onetime'
                    ]),
                ]
            ],
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl
            ]
        ];
        $response = $this->client->post("{$this->baseUrl}/v2/checkout/orders", [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => $payload
        ]);

        return json_decode($response->getBody(), true);
    }

    public function captureOrder($orderId)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture", [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getOrderDetails($orderId)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->get("{$this->baseUrl}/v2/checkout/orders/{$orderId}", [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
    public function onetimeSuccess(Request $request)
    {
        try {
            $orderId = $request->query('token'); // PayPal sends order ID in `token`

            if ($orderId == null) {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            $result = $this->captureOrder($orderId);
            $captures_id = $result['purchase_units'][0]['payments']['captures'][0]['id'];

            $custom = json_decode($result['purchase_units'][0]['payments']['captures'][0]['custom_id'], true);
            $subscription_id = $custom['subscription_id'] ?? null;

            $user_plan = Subscriptions::find($subscription_id);
            if (isset($user_plan) && $user_plan != null && $user_plan->is_processed == false) {
                $this->subscriptionService->chargeSucceeded($captures_id, $subscription_id);
            }
            return redirect('home')->with('Success', trans('system.plans.play_change_success'));
        } catch (\Exception $ex) {
            return redirect('subscription')->with(['Error' => $ex->getMessage()]);
        }
    }

    public function onetimeCancelled(Request $request)
    {
        try {
            $orderId = $request->query('token'); // PayPal sends order ID in `token`

            if ($orderId == null) {
                throw new \Exception(trans('system.plans.invalid_payment'));
            }

            $result = $this->getOrderDetails($orderId);
            $custom = json_decode($result['purchase_units'][0]['custom_id'], true);
            $subscription_id = $custom['subscription_id'] ?? null;

            $user_plan = Subscriptions::where('id', $subscription_id)->where('status', 'pending')->first();
            if (isset($user_plan) && $user_plan != null) {
                Subscriptions::where('id', $subscription_id)->delete();
            }
            return redirect('subscription')->with('Error', trans('system.plans.invalid_payment'));
        } catch (\Exception $ex) {
            return redirect('subscription')->with('Error', $ex->getMessage());
        }
    }

}
