<?php
return [
    'route_prefix' => 'bisbond',

    'route_middleware' => ['web', 'auth'],

    'dashboard' => [
        'enabled' => true,
        'title' => 'Laravel Bisbond',
    ],

    'modules' => [
        'formatter' => true,
        'invoice' => true,
        'sms' => true,
        'payments' => false,
    ],

    'defaults' => [
        'locale' => 'bn',
        'currency' => 'BDT',
        'currency_symbol' => '৳',
        'use_bangla_digits' => true,
        'invoice_prefix' => 'INV-',
    ],
];
