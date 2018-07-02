<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
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
        'region' => env('SES_REGION', 'us-east-1'),
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
        'client_id' => env('FACEBOOK_CLIENT_ID','1750313031714584'),         // Your Facebook Client ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET','4e694addf54c3435dbc3b776836e4f91'), // Your Facebook Client Secret
        'redirect' => 'http://127.0.0.1:8000/login/facebook/callback',
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID','74597539967-2gekbu2gfd2cdhmso9bvnfdvhmnv2mqi.apps.googleusercontent.com'),         // Your Google Client ID
        'client_secret' => env('GOOGLE_CLIENT_SECRET','rmsPeYTXG5aORbDedLfhUDNj'), // Your Google Client Secret
        'redirect' => 'http://127.0.0.1:8000/login/google/callback',
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID','WFR1jEvMD4qwW5pPkyLq6fSBA'),         // Your Twitter Client ID
        'client_secret' => env('TWITTER_CLIENT_SECRET','ftY0tDUXjIZQEgOfsikFU9ytWn9x2AOtXjAf3AwzVXrVl6NSoV'), // Your Twitter Client Secret
        'redirect' => 'http://127.0.0.1:8000/login/twitter/callback',
    ],

    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID','81ihgwsvslny37'),         // Your Linkedin Client ID
        'client_secret' => env('LINKEDIN_CLIENT_SECRET','NvBdKECO3Y22vEKR'), // Your Linkedin Client Secret
        'redirect' => 'http://127.0.0.1:8000/login/linkedin/callback',
    ],
];
