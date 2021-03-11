<?php

return [
    'merchant_number' => env('IME_PAY_MERCHANT_NUMBER'),
    'merchant_name' => env('IME_PAY_MERCHANT_NAME'),
    'merchant_code' => env('IME_PAY_MERCHANT_CODE'),
    'merchant_module' => env('IME_PAY_MERCHANT_MODULE'),
    'username' => env('IME_PAY_USERNAME'),
    'password' => env('IME_PAY_PASSWORD'),
    /**
     * The payment url
     * 
     * E.g. https://stg.imepay.com.np:1234
     */
    'base_url' => env('IME_PAY_BASE_URL'),
];
