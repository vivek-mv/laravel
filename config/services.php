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
        'client_id' => '598791373619625',
        'client_secret' => '3eda463fc4100c2f2f44352a432b9ec1',
        'redirect' => 'http://laravel.local.com/loginWithOthers',
    ],
    'google' => [
        'client_id' => '525154430213-nllv3trodb3jrou82r131db0vkdnqbpc.apps.googleusercontent.com',
        'client_secret' => '8phAGMJdehChwogDmSu-bVLv',
        'redirect' => 'http://laravel.local.com/loginWithOthers/1',
    ],
    'linkedin' => [
        'client_id' => '81oh27kjsjbuky',
        'client_secret' => '3HEiSujs3GM4J3Cv',
        'redirect' => 'http://laravel.local.com/loginWithOthers/2',
    ],
    'twitter' => [
        'client_id' => 'BFOufTojJBFozVFSVK8g71ddY',
        'client_secret' => 'PEXNRWbwqlVx2KfecNJy3iKvrfJ7ARK13ndSZKs3TxRhYRe55l',
        'redirect' => 'http://laravel.local.com/loginWithOthers/3',
    ]

];
