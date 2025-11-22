<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Security Event Model
 * 
 * Logs security-related events for monitoring and auditing
 * 
 * @package App\Models
 */
class SecurityEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'severity',
        'user_id',
        'user_type',
        'ip_address',
        'user_agent',
        'description',
        'metadata',
        'resolved',
        'resolved_at',
        'resolved_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'resolved' => 'boolean',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Event types
     */
    const TYPE_LOGIN_SUCCESS = 'login_success';
    const TYPE_LOGIN_FAILED = 'login_failed';
    const TYPE_ACCOUNT_LOCKED = 'account_locked';
    const TYPE_SUSPICIOUS_ACTIVITY = 'suspicious_activity';
    const TYPE_RATE_LIMIT_EXCEEDED = 'rate_limit_exceeded';
    const TYPE_FILE_UPLOAD_SUSPICIOUS = 'file_upload_suspicious';
    const TYPE_ENCRYPTION_ERROR = 'encryption_error';
    const TYPE_DECRYPTION_ERROR = 'decryption_error';
    const TYPE_CSRF_VIOLATION = 'csrf_violation';
    const TYPE_XSS_ATTEMPT = 'xss_attempt';
    const TYPE_SQL_INJECTION_ATTEMPT = 'sql_injection_attempt';
    const TYPE_PASSWORD_CHANGED = 'password_changed';
    const TYPE_2FA_ENABLED = '2fa_enabled';
    const TYPE_2FA_DISABLED = '2fa_disabled';
    const TYPE_SESSION_HIJACK_ATTEMPT = 'session_hijack_attempt';

    /**
     * Severity levels
     */
    const SEVERITY_LOW = 'low';
    const SEVERITY_MEDIUM = 'medium';
    const SEVERITY_HIGH = 'high';
    const SEVERITY_CRITICAL = 'critical';

    /**
     * Log a security event
     *
     * @param string $eventType
     * @param string $severity
     * @param array $data
     * @return self
     */
    public static function log(
        string $eventType,
        string $severity = self::SEVERITY_MEDIUM,
        array $data = []
    ): self {
        return self::create([
            'event_type' => $eventType,
            'severity' => $severity,
            'user_id' => $data['user_id'] ?? null,
            'user_type' => $data['user_type'] ?? null,
            'ip_address' => $data['ip_address'] ?? request()->ip(),
            'user_agent' => $data['user_agent'] ?? request()->userAgent(),
            'description' => $data['description'] ?? self::getDefaultDescription($eventType),
            'metadata' => $data['metadata'] ?? [],
            'resolved' => false,
        ]);
    }

    /**
     * Get default description for event type
     *
     * @param string $eventType
     * @return string
     */
    private static function getDefaultDescription(string $eventType): string
    {
        return match($eventType) {
            self::TYPE_LOGIN_SUCCESS => 'Successful login attempt',
            self::TYPE_LOGIN_FAILED => 'Failed login attempt',
            self::TYPE_ACCOUNT_LOCKED => 'Account locked due to multiple failed attempts',
            self::TYPE_SUSPICIOUS_ACTIVITY => 'Suspicious activity detected',
            self::TYPE_RATE_LIMIT_EXCEEDED => 'Rate limit exceeded',
            self::TYPE_FILE_UPLOAD_SUSPICIOUS => 'Suspicious file upload detected',
            self::TYPE_ENCRYPTION_ERROR => 'Encryption operation failed',
            self::TYPE_DECRYPTION_ERROR => 'Decryption operation failed',
            self::TYPE_CSRF_VIOLATION => 'CSRF token validation failed',
            self::TYPE_XSS_ATTEMPT => 'Potential XSS attack detected',
            self::TYPE_SQL_INJECTION_ATTEMPT => 'Potential SQL injection attempt detected',
            self::TYPE_PASSWORD_CHANGED => 'Password changed successfully',
            self::TYPE_2FA_ENABLED => 'Two-factor authentication enabled',
            self::TYPE_2FA_DISABLED => 'Two-factor authentication disabled',
            self::TYPE_SESSION_HIJACK_ATTEMPT => 'Potential session hijacking attempt',
            default => 'Security event occurred',
        };
    }

    /**
     * Get unresolved critical events
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUnresolvedCritical()
    {
        return self::where('severity', self::SEVERITY_CRITICAL)
            ->where('resolved', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mark event as resolved
     *
     * @param int $resolvedBy
     * @return bool
     */
    public function markAsResolved(int $resolvedBy): bool
    {
        return $this->update([
            'resolved' => true,
            'resolved_at' => now(),
            'resolved_by' => $resolvedBy,
        ]);
    }
}

