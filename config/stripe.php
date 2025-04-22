<?php
return [
    'stripe_publish_key' => env('STRIPE_PUBLISH_KEY'),
    'stripe_secret_key' => env('STRIPE_SECRET_KEY'),
    'stripe_status' => env('STRIPE_STATUS'),
    'currency' => env('STRIPE_CURRENCY_CODE'),
    'mode' => env('STRIPE_MODE', 'test'),
];
