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
        // Production-safe account slots. Environment variables remain authoritative,
        // but the application must never fall back to the invalid 0000000000 placeholder.
        'slot_id'         => env('ADSENSE_SLOT_ID', '4457701474'),
        'slot_in_content' => env('ADSENSE_SLOT_IN_CONTENT', '8299147673'),
        'slot_post_read'  => env('ADSENSE_SLOT_POST_READ',  '1448394751'),
        'slot_in_feed'    => env('ADSENSE_SLOT_IN_FEED',    '4457701474'),
    ],

    'mora' => [
        'openai_key'     => env('MORA_OPENAI_KEY'),
        'openai_model'   => env('MORA_OPENAI_MODEL', 'gpt-5.4-mini'),
        'gemini_key'     => env('MORA_GEMINI_KEY'),
        'claude_key'     => env('MORA_CLAUDE_KEY'),
        'deepseek_key'   => env('MORA_DEEPSEEK_KEY'),
        'portal_webhook' => env('MORA_PORTAL_WEBHOOK_URL', 'https://portal.m2b.co.id/api/mora-lead-incoming'),
        'portal_secret'  => env('MORA_PORTAL_WEBHOOK_SECRET'),
    ],

];
