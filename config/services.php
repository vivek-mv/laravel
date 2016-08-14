<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => env('FB_CLIENTID'),
        'client_secret' => env('FB_SECRET'),
        'redirect' => 'http://laravel.local.com/loginWithOthers',
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENTID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => 'http://laravel.local.com/loginWithOthers/1',
    ],
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENTID'),
        'client_secret' =>  env('LINKEDIN_SECRET'),
        'redirect' => 'http://laravel.local.com/loginWithOthers/2',
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENTID'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect' => 'http://laravel.local.com/loginWithOthers/3',
    ],
    'instagram' => [
        'client_id' => env('INSTAGRAM_CLIENTID'),
        'client_secret' => env('INSTAGRAM_SECRET'),
        'redirect' => 'http://laravel.local.com/loginWithOthers/4',
    ]

];
