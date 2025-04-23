<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use GuzzleHttp\Client;

class PayPalController extends Controller
{
    protected $payPalService;
    private $client;
    private $baseUrl;


    public function __construct()
    {
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
        $result = $this->getSubscription($request->subscription_id);
        dd($result);
        return response()->json(['message' => 'Subscription successful!', 'data' => $request->all()]);
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

        return "Subscription Canceled";
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
}
