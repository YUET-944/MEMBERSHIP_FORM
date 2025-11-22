<?php

return [
    'name' => env('APP_NAME', 'National Membership System'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    
    // Encryption key for sensitive data
    'encryption_key' => env('ENCRYPTION_KEY'),
    
    // OTP Configuration
    'otp_expiry_minutes' => env('OTP_EXPIRY_MINUTES', 10),
    'otp_max_attempts' => env('OTP_MAX_ATTEMPTS', 5),
    
    // Two-Factor Authentication
    'two_factor_issuer' => env('TWO_FACTOR_ISSUER', 'National Membership System'),
];

