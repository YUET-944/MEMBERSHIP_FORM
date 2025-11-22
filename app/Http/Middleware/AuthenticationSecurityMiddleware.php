<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\LoginAttempt;
use App\Models\SecurityEvent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authentication Security Middleware
 * 
 * Implements authentication hardening:
 * - Login attempt monitoring
 * - Account lockout after failed attempts
 * - Session security (regeneration, timeout)
 * - Device fingerprinting
 * - Suspicious activity detection
 * 
 * @package App\Http\Middleware
 */
class AuthenticationSecurityMiddleware
{
    /**
     * Maximum failed login attempts before lockout
     */
    private int $maxFailedAttempts = 5;

    /**
     * Lockout duration in minutes
     */
    private int $lockoutDuration = 15;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Regenerate session ID periodically for security
        if (!$request->session()->has('session_regenerated')) {
            $request->session()->regenerate();
            $request->session()->put('session_regenerated', true);
        }

        // Check for suspicious session activity
        $this->checkSessionSecurity($request);

        $response = $next($request);

        // Add security headers to response
        $response->headers->set('X-Session-Timeout', config('session.lifetime', 120));

        return $response;
    }

    /**
     * Check session security
     *
     * @param Request $request
     * @return void
     */
    private function checkSessionSecurity(Request $request): void
    {
        $session = $request->session();
        
        // Device fingerprinting
        $currentFingerprint = $this->generateDeviceFingerprint($request);
        $storedFingerprint = $session->get('device_fingerprint');

        if ($storedFingerprint && $storedFingerprint !== $currentFingerprint) {
            // Potential session hijacking attempt
            SecurityEvent::log(
                SecurityEvent::TYPE_SESSION_HIJACK_ATTEMPT,
                SecurityEvent::SEVERITY_CRITICAL,
                [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'stored_fingerprint' => $storedFingerprint,
                    'current_fingerprint' => $currentFingerprint,
                    'user_id' => auth()->id(),
                ]
            );

            // Invalidate session
            $session->invalidate();
            $session->regenerateToken();
        } else {
            // Store fingerprint if not exists
            if (!$storedFingerprint) {
                $session->put('device_fingerprint', $currentFingerprint);
            }
        }
    }

    /**
     * Generate device fingerprint
     *
     * @param Request $request
     * @return string
     */
    private function generateDeviceFingerprint(Request $request): string
    {
        $components = [
            $request->ip(),
            $request->userAgent(),
            $request->header('Accept-Language'),
            $request->header('Accept-Encoding'),
        ];

        return hash('sha256', implode('|', $components));
    }

    /**
     * Check if account should be locked
     *
     * @param string $email
     * @param string $ip
     * @return bool
     */
    public static function shouldLockAccount(string $email, string $ip): bool
    {
        $emailAttempts = LoginAttempt::getFailedAttemptsForEmail($email, 15);
        $ipAttempts = LoginAttempt::getFailedAttemptsCount($ip, 15);

        return $emailAttempts >= 5 || $ipAttempts >= 10;
    }

    /**
     * Record failed login attempt
     *
     * @param string $email
     * @param string $ip
     * @param string|null $userAgent
     * @param string|null $reason
     * @return void
     */
    public static function recordFailedAttempt(
        string $email,
        string $ip,
        ?string $userAgent = null,
        ?string $reason = null
    ): void {
        LoginAttempt::record($email, $ip, $userAgent, false, $reason);

        // Check if account should be locked
        if (self::shouldLockAccount($email, $ip)) {
            SecurityEvent::log(
                SecurityEvent::TYPE_ACCOUNT_LOCKED,
                SecurityEvent::SEVERITY_HIGH,
                [
                    'email' => $email,
                    'ip_address' => $ip,
                    'reason' => 'Multiple failed login attempts',
                ]
            );
        }
    }

    /**
     * Record successful login attempt
     *
     * @param string $email
     * @param string $ip
     * @param string|null $userAgent
     * @return void
     */
    public static function recordSuccessfulAttempt(
        string $email,
        string $ip,
        ?string $userAgent = null
    ): void {
        LoginAttempt::record($email, $ip, $userAgent, true);

        SecurityEvent::log(
            SecurityEvent::TYPE_LOGIN_SUCCESS,
            SecurityEvent::SEVERITY_LOW,
            [
                'email' => $email,
                'ip_address' => $ip,
            ]
        );
    }
}

