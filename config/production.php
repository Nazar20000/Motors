<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Production Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains production-specific configurations for the application.
    |
    */

    'debug' => false,
    'optimize' => true,
    
    'cache' => [
        'config' => true,
        'routes' => true,
        'views' => true,
    ],
    
    'session' => [
        'secure' => true,
        'same_site' => 'strict',
        'encrypt' => true,
    ],
    
    'security' => [
        'headers' => [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
        ],
    ],
];
