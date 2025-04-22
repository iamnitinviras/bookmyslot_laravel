<?php
return [
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'secret' => env('PAYPAL_SECRET_KEY'),
    'currency' => env('PAYPAL_CURRENCY_CODE'),
    'status' => env('PAYPAL_STATUS'),
    'mode' => env('PAYPAL_MODE', 'sandbox'),
];
