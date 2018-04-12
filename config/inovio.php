<?php


return [
    'username' => env('INOVIO_USERNAME'),
    'password' => env('INOVIO_PASSWORD'),
    'site_id' => env('INOVIO_SITEID'),
    'currency' => env('INOVIO_CURRENCY', 'USD'),
    'merchant_acct_id' => env('INOVIO_MERCHANT_ACCOUNTID'),
    'users_table' => env('INOVIO_USERS_TABLE', 'users'),
];