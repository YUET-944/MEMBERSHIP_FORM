<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Enterprise-grade security settings for the application
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limiting' => [
        'login' => [
            'max_attempts' => 5,
            'decay_minutes' => 1,
        ],
        'register' => [
            'max_attempts' => 3,
            'decay_minutes' => 1,
        ],
        'api' => [
            'max_attempts' => 60,
            'decay_minutes' => 60,
        ],
        'otp' => [
            'max_attempts' => 5,
            'decay_minutes' => 15,
        ],
        'password_reset' => [
            'max_attempts' => 3,
            'decay_minutes' => 15,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Security
    |--------------------------------------------------------------------------
    */
    'authentication' => [
        'max_failed_attempts' => 5,
        'lockout_duration_minutes' => 15,
        'session_timeout_minutes' => 120,
        'session_regeneration_interval' => 30, // Regenerate every 30 requests
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Security
    |--------------------------------------------------------------------------
    */
    'file_upload' => [
        'max_size' => 2097152, // 2MB in bytes
        'allowed_mimes' => [
            'image' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
            'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        ],
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx'],
        'scan_for_malware' => env('ENABLE_MALWARE_SCANNING', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    */
    'csp' => [
        'enabled' => env('CSP_ENABLED', true),
        'report_only' => env('CSP_REPORT_ONLY', false),
        'report_uri' => env('CSP_REPORT_URI', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption
    |--------------------------------------------------------------------------
    */
    'encryption' => [
        'cipher' => 'AES-256-CBC',
        'key_rotation_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Monitoring
    |--------------------------------------------------------------------------
    */
    'monitoring' => [
        'log_all_events' => env('LOG_ALL_SECURITY_EVENTS', true),
        'alert_on_critical' => env('ALERT_ON_CRITICAL_EVENTS', true),
        'retention_days' => 90,
    ],
];

