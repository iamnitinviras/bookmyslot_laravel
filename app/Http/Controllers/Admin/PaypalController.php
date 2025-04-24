<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Services\Subscription;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PayPalController extends Controller
{
    private $client;
    private $baseUrl;

    protected $subscriptionService;
    public function __construct(Subscription $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->client = new Client();
        $this->baseUrl = config('paypal.mode') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';
    }

    private function getAccessToken()
    {
        $response = $this->client->post("{$this->baseUrl}/v1/oauth2/token", [
            'auth' => [config('paypal.client_id'), config('paypal.secret')],
            'form_params' => ['grant_type' => 'client_credentials'],
        ]);

        return json_decode($response->getBody(), true)['access_token'];
    }

    // Create Subscription
    public function createPaypalSubscription($paypal_plan_type, $user, $plan, $subscriptionId)
    {
        $subscription = $this->createSubscription(
            $paypal_plan_type,
            $user,
            $plan,
            $subscriptionId,
            route('admin.paypal.success'),
            route('admin.paypal.cancel')
        );

        return redirect($subscription['links'][0]['href']);
    }

    // Success Route
    public function success(Request $request)
    {
        try {
            $result = $this->getSubscription($request->subscription_id);
            if (isset($result) && count($result) > 0) {

                $subscription = Subscriptions::find($result['custom_id']);
                if ($subscription == null) {
                    throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
                }

                $this->subscriptionService->invoicePaid($subscription, $result['id'], time());
                return redirect('home')->with('Success', trans('system.plans.play_change_success'));
            } else {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }
        } catch (\Exception $exception) {
            dd($exception);
            return redirect('subscription')->with(['Error' => $exception->getMessage()]);
        }
    }

    public function createPlan($paypal_plan_type, $plan)
    {
        $title = $plan->title;
        $amount = $plan->amount;
        $description = $plan->description;

        $accessToken = $this->getAccessToken();

        //Get ProductID
        $paypal_plan_id = $plan->paypal_plan_id;

        if ($plan->paypal_plan_id == null) {

            $product = $this->createProduct($title, $description);

            $response = $this->client->post("{$this->baseUrl}/v1/billing/plans", [
                'headers' => ['Authorization' => "Bearer $accessToken", 'Content-Type' => 'application/json'],
                'json' => [
                    'product_id' => $product['id'], // Get from PayPal Developer Dashboard
                    'name' => $title,
                    'status' => 'ACTIVE',
                    'billing_cycles' => [
                        [
                            'frequency' => ['interval_unit' => $paypal_plan_type, 'interval_count' => 1],
                            'tenure_type' => 'REGULAR',
                            'sequence' => 1,
                            'total_cycles' => 0,
                            'pricing_scheme' => ['fixed_price' => ['value' => $amount, 'currency_code' => config('paypal.currency')]]
                        ]
                    ],
                    'payment_preferences' => [
                        'auto_bill_outstanding' => true,
                        'setup_fee' => ['value' => '0', 'currency_code' => config('paypal.currency')],
                        'setup_fee_failure_action' => 'CANCEL',
                        'payment_failure_threshold' => 3
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            $paypal_plan_id = $result['id'] ?? null;
            $plan->paypal_plan_id = $result['id'] ?? null;
            $plan->save();
        }
        return $paypal_plan_id;
    }

    // Create a Subscription
    public function createSubscription($paypal_plan_type, $user, $plan, $subscriptionId, $returnUrl, $cancelUrl)
    {
        $accessToken = $this->getAccessToken();
        $planId = $this->createPlan($paypal_plan_type, $plan);

        $email = $user->email;

        $payload = [
            'plan_id' => $planId,
            'custom_id' => $subscriptionId,
            'subscriber' => [
                'name' => [
                    'given_name' => $user->first_name,
                    'surname' => $user->last_name
                ],
                'email_address' => $email
            ],
            'application_context' => [
                'brand_name' => config('app.name'),
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl
            ]
        ];
        $response = $this->client->post("{$this->baseUrl}/v1/billing/subscriptions", [
            'headers' => ['Authorization' => "Bearer $accessToken", 'Content-Type' => 'application/json'],
            'json' => $payload
        ]);
        return json_decode($response->getBody(), true);
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
                    'custom_id' => $user_plan->id,
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
            $subscription_id = $result['purchase_units'][0]['payments']['captures'][0]['custom_id'];

            $user_plan = Subscriptions::find($subscription_id);
            if (isset($user_plan) && $user_plan != null && $user_plan->is_processed == false) {
                $this->subscriptionService->chargeSucceeded($captures_id, $subscription_id);
            }
            return redirect('home')->with('Success', trans('system.plans.play_change_success'));
        } catch (\Exception $ex) {
            return redirect('subscription/plan')->with(['Error' => $ex->getMessage()]);
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
            $subscription_id = $result['purchase_units'][0]['custom_id'];

            $user_plan = Subscriptions::where('id', $subscription_id)->where('status', 'pending')->first();
            if (isset($user_plan) && $user_plan != null) {
                Subscriptions::where('id', $subscription_id)->delete();
            }
            return redirect('subscription')->with('Error', trans('system.plans.invalid_payment'));
        } catch (\Exception $ex) {
            dd($ex);
            return redirect('subscription')->with('Error', $ex->getMessage());
        }
    }

}
