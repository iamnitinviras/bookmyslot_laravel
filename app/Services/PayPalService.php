<?php
// app/Services/PayPalService.php

namespace App\Services;

use GuzzleHttp\Client;

class PayPalService
{
    private $client;
    private $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('paypal.mode') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';
    }

    // Get Access Token
    private function getAccessToken()
    {
        $response = $this->client->post("{$this->baseUrl}/v1/oauth2/token", [
            'auth' => [config('paypal.client_id'), config('paypal.secret')],
            'form_params' => ['grant_type' => 'client_credentials'],
        ]);

        return json_decode($response->getBody(), true)['access_token'];
    }

    // Create a Subscription Plan
    public function createPlan($name, $price)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post("{$this->baseUrl}/v1/billing/plans", [
            'headers' => ['Authorization' => "Bearer $accessToken", 'Content-Type' => 'application/json'],
            'json' => [
                'product_id' => 'your-product-id', // Get from PayPal Developer Dashboard
                'name' => $name,
                'status' => 'ACTIVE',
                'billing_cycles' => [
                    [
                        'frequency' => ['interval_unit' => 'MONTH', 'interval_count' => 1],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => ['fixed_price' => ['value' => $price, 'currency_code' => 'USD']]
                    ]
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee' => ['value' => '0', 'currency_code' => 'USD'],
                    'setup_fee_failure_action' => 'CANCEL',
                    'payment_failure_threshold' => 3
                ]
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    // Create a Subscription
    public function createSubscription($planId, $returnUrl, $cancelUrl)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post("{$this->baseUrl}/v1/billing/subscriptions", [
            'headers' => ['Authorization' => "Bearer $accessToken", 'Content-Type' => 'application/json'],
            'json' => [
                'plan_id' => $planId,
                'subscriber' => ['email_address' => 'customer@example.com'],
                'application_context' => [
                    'brand_name' => 'Your App Name',
                    'return_url' => $returnUrl,
                    'cancel_url' => $cancelUrl
                ]
            ]
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
}
