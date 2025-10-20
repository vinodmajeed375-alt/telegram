<?php

return [
    // Add you bot's API key and name
    'api_key_q'      => '7523473624:AAHk6iFslMuYzehrvRjyJiiUInxgopG-9BM',
    'bot_username_q' => 'abcdsquery_bot',
    'api_key'      => '7619626384:AAGsN79BWYLMbXDguTO1Kh0vOa7hYopOeQw',
    'bot_username' => 'xixipay123_bot',
    'api_domain'=>'https://www.abbspay.com',
    'mysql'=>[
        'host'     => '127.0.0.1',
        'port'     => 3306, // optional
        'user'     => 'telegram',
        'password' => 'NYDkxxx3faHdKDLy',
        'database' => 'telegram',
    ],
    // [Manager Only] Secret key required to access the webhook
    'secret'       => 'super_secret',
    // When using the getUpdates method, this can be commented out
    'webhook'      => [
        'url' => 'https://abcds1234.com/hook/index',
        'urlquery' => 'https://abcds1234.com/hookquery/index',
        // Use self-signed certificate
        // 'certificate'     => __DIR__ . '/path/to/your/certificate.crt',
        // Limit maximum number of connections
        // 'max_connections' => 5,
    ],
    // All command related configs go here
    'commands'     => [
        // Define all paths for your custom commands
        // DO NOT PUT THE COMMAND FOLDER THERE. IT WILL NOT WORK.
        // Copy each needed Commandfile into the CustomCommand folder and uncommend the Line 49 below
        'paths'   => [
            root_path() . 'Commands',
        ],
        // Here you can set any command-specific parameters
        'configs' => [
            // - Google geocode/timezone API key for /date command (see DateCommand.php)
            'date'    => ['google_api_key' => 'your_google_api_key_here'],
            // - OpenWeatherMap.org API key for /weather command (see WeatherCommand.php)
            'weather' => ['owm_api_key' => 'your_owm_api_key_here'],
            // - Payment Provider Token for /payment command (see Payments/PaymentCommand.php)
            // 'payment' => ['payment_provider_token' => 'your_payment_provider_token_here'],
        ],
    ],

    // Define all IDs of admin users
    'admins'       => [
        // 123,
    ],

    'paths'        => [
        'download' => __DIR__ . '/Download',
        'upload'   => __DIR__ . '/Upload',
    ],

    // Requests Limiter (tries to prevent reaching Telegram API limits)
    'limiter'      => [
        'enabled' => true,
    ],
];