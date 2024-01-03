<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Cookie Cart settings
    |--------------------------------------------------------------------------
    |
    */

    'cookie' => [
        'name' => env('CART_COOKIE_NAME', 'cart_cookie'),
        'expiration' => 7 * 24 * 60
    ]
];