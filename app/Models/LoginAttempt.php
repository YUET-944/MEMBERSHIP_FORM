<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Login Attempt Model
 * 
 * Tracks login attempts for brute force protection
 * 
 * @package App\Models
 */
class LoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'success',
        'failure_reason',
        'attempted_at',
    ];

    protected $casts = [
        'success' => 'boolean',
        'attempted_at' => 'datetime',
    ];

    /**
     * Get failed attempts count for IP in last minutes
     *
     * @param string $ip
     * @param int $minutes
     * @return int
     */
    public static function getFailedAttemptsCount(string $ip, int $minutes = 15): int
    {
        return self::where('ip_address', $ip)
            ->where('success', false)
            ->where('attempted_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    /**
     * Get failed attempts count for email in last minutes
     *
     * @param string $email
     * @param int $minutes
     * @return int
     */
    public static function getFailedAttemptsForEmail(string $email, int $minutes = 15): int
    {
        return self::where('email', $email)
            ->where('success', false)
            ->where('attempted_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    /**
     * Record login attempt
     *
     * @param string $email
     * @param string $ip
     * @param string|null $userAgent
     * @param bool $success
     * @param string|null $failureReason
     * @return self
     */
    public static function record(
        string $email,
        string $ip,
        ?string $userAgent = null,
        bool $success = false,
        ?string $failureReason = null
    ): self {
        return self::create([
            'email' => $email,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'success' => $success,
            'failure_reason' => $failureReason,
            'attempted_at' => now(),
        ]);
    }

    /**
     * Check if IP should be blocked
     *
     * @param string $ip
     * @param int $maxAttempts
     * @return bool
     */
    public static function shouldBlockIp(string $ip, int $maxAttempts = 5): bool
    {
        return self::getFailedAttemptsCount($ip) >= $maxAttempts;
    }

    /**
     * Check if email should be blocked
     *
     * @param string $email
     * @param int $maxAttempts
     * @return bool
     */
    public static function shouldBlockEmail(string $email, int $maxAttempts = 5): bool
    {
        return self::getFailedAttemptsForEmail($email) >= $maxAttempts;
    }
}

