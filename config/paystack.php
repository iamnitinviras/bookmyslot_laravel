<?php
return [
    'public_key' => env('PAYSTACK_PUBLIC_KEY'),
    'secret' => env('PAYSTACK_SECRET_KEY'),
    'currency' => env('PAYSTACK_CURRENCY_CODE'),
    'status' => env('PAYSTACK_STATUS'),
    'mode' => env('PAYSTACK_MODE', 'test'),
];
