<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],


    'adsense' => [
        'publisher_id'   => env('ADSENSE_PUBLISHER_ID', 'ca-pub-5616961797801657'),
        'slot_id'        => env('ADSENSE_SLOT_ID', '0000000000'),
        'slot_in_content' => env('ADSENSE_SLOT_IN_CONTENT', env('ADSENSE_SLOT_ID', '0000000000')),
        'slot_post_read'  => env('ADSENSE_SLOT_POST_READ',  env('ADSENSE_SLOT_ID', '0000000000')),
        'slot_in_feed'    => env('ADSENSE_SLOT_IN_FEED',    env('ADSENSE_SLOT_ID', '0000000000')),
    ],

    'mora' => [
        'gemini_key' => env('MORA_GEMINI_KEY'),
        'claude_key' => env('MORA_CLAUDE_KEY'),
    ],

];
