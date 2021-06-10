<?php

return [
    'language' => 'ru',
    'timeZone' => 'Europe/Moscow',
    'components' => [
        'request' => [
            'url' => [
                'api_path' => 'api',
                'admin_path' => 'admin',
            ],
            'onlySSL' => false,
            'enableCookieValidation' => true,
            'cookieValidationKey' => '7843hfdjks8',
            'multiCookieDomain' => false
        ],
        'user' => [
            'identityClass' => 'Reagordi\\CMS\\Components\\User',
            'loginUrl' => 'auth',
            'reg' => false
        ],
        'cache' => [
            'type' => 'files',
            'value' => [
                'host' => 'localhost',
                'port' => 6379
            ]
        ],
        'mailer' => [
            'adminEmail' => 'admin@example.com',
            'senderEmail' => 'noreply@example.com',
            'senderName' => 'Example.com mailer',
        ],
        'log' => [
            'traceLevel' => 0
        ],
        'optimize' => [
            'html' => false,
            'css' => false,
            'js' => false,
        ],
    ],
    'modules' => [],
];
