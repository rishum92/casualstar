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
    
    'facebook' => [
        'client_id' => getenv('FACEBOOK_ID'),
        'client_secret' => getenv('FACEBOOK_SECRET'),
        'redirect' => getenv('HTTP_TYPE') . '://' . getenv('NODE_HOST') . '/login/callback/facebook'
    ],

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

	'twitter' => [
        'client_id'     => env('TWITTER_ID'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect'      => env('TWITTER_URL'),
    ],
	/* 
	'twitter' => [
        'client_id' => getenv('TWITTER_ID'),
        'client_secret' => getenv('TWITTER_SECRET'),
        'redirect' => 'http://localhost:8000/login/callback/twitter'
    ], */
];
