<?php
return [
    'key_id' => env('RAZORPAY_KEY_ID'),
    'secret' => env('RAZORPAY_SECRET_KEY'),
    'currency' => env('RAZORPAY_CURRENCY_CODE'),
    'status' => env('RAZORPAY_STATUS'),
    'mode' => env('RAZORPAY_MODE', 'test'),
];
