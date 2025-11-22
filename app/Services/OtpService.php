<?php

namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

/**
 * OTP (One-Time Password) Service
 * 
 * Handles OTP generation, validation, and expiration
 * Supports Email and SMS OTP delivery
 * 
 * @package App\Services
 */
class OtpService
{
    /**
     * OTP expiry time in minutes
     */
    private int $expiryMinutes;

    /**
     * Maximum OTP attempts
     */
    private int $maxAttempts;

    /**
     * Initialize OTP service
     */
    public function __construct()
    {
        $this->expiryMinutes = (int) config('app.otp_expiry_minutes', 10);
        $this->maxAttempts = (int) config('app.otp_max_attempts', 5);
    }

    /**
     * Generate OTP for user
     * 
     * @param string $identifier Email or phone number
     * @param string $type 'email' or 'sms'
     * @param string $purpose Purpose of OTP (registration, login, etc.)
     * @return string Generated OTP
     * @throws Exception
     */
    public function generate(string $identifier, string $type = 'email', string $purpose = 'verification'): string
    {
        // Validate type
        if (!in_array($type, ['email', 'sms'])) {
            throw new Exception('Invalid OTP type. Must be email or sms');
        }

        // Check rate limiting
        $rateLimitKey = "otp_rate_limit:{$identifier}:{$type}";
        $attempts = Cache::get($rateLimitKey, 0);
        
        if ($attempts >= 5) {
            throw new Exception('Too many OTP requests. Please try again later.');
        }

        // Generate 6-digit OTP
        $otp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in database
        $otpRecord = OtpVerification::create([
            'identifier' => $identifier,
            'type' => $type,
            'otp_code' => $this->hashOtp($otp),
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes($this->expiryMinutes),
            'attempts' => 0,
            'is_verified' => false,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Cache OTP for quick validation (encrypted)
        $cacheKey = "otp:{$otpRecord->id}";
        Cache::put($cacheKey, $otp, now()->addMinutes($this->expiryMinutes));

        // Update rate limit
        Cache::put($rateLimitKey, $attempts + 1, now()->addMinutes(15));

        // Log OTP generation
        Log::channel('security')->info('OTP generated', [
            'identifier' => $this->maskIdentifier($identifier),
            'type' => $type,
            'purpose' => $purpose,
            'expires_at' => $otpRecord->expires_at,
        ]);

        return $otp;
    }

    /**
     * Verify OTP
     * 
     * @param string $identifier Email or phone number
     * @param string $otp OTP to verify
     * @param string $type 'email' or 'sms'
     * @return bool Verification status
     */
    public function verify(string $identifier, string $otp, string $type = 'email'): bool
    {
        // Find latest unverified OTP
        $otpRecord = OtpVerification::where('identifier', $identifier)
            ->where('type', $type)
            ->where('is_verified', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            Log::channel('security')->warning('OTP verification failed: No valid OTP found', [
                'identifier' => $this->maskIdentifier($identifier),
            ]);
            return false;
        }

        // Check attempts
        if ($otpRecord->attempts >= $this->maxAttempts) {
            Log::channel('security')->warning('OTP verification failed: Max attempts exceeded', [
                'identifier' => $this->maskIdentifier($identifier),
            ]);
            return false;
        }

        // Increment attempts
        $otpRecord->increment('attempts');

        // Verify OTP
        $cacheKey = "otp:{$otpRecord->id}";
        $cachedOtp = Cache::get($cacheKey);

        $isValid = false;
        if ($cachedOtp && hash_equals($cachedOtp, $otp)) {
            $isValid = true;
        } elseif ($this->verifyOtpHash($otp, $otpRecord->otp_code)) {
            $isValid = true;
        }

        if ($isValid) {
            // Mark as verified
            $otpRecord->update([
                'is_verified' => true,
                'verified_at' => now(),
            ]);

            // Clear cache
            Cache::forget($cacheKey);

            // Invalidate all other OTPs for this identifier
            OtpVerification::where('identifier', $identifier)
                ->where('id', '!=', $otpRecord->id)
                ->where('is_verified', false)
                ->update(['expires_at' => now()]);

            Log::channel('security')->info('OTP verified successfully', [
                'identifier' => $this->maskIdentifier($identifier),
            ]);

            return true;
        }

        Log::channel('security')->warning('OTP verification failed: Invalid OTP', [
            'identifier' => $this->maskIdentifier($identifier),
            'attempts' => $otpRecord->attempts,
        ]);

        return false;
    }

    /**
     * Resend OTP
     * 
     * @param string $identifier Email or phone number
     * @param string $type 'email' or 'sms'
     * @return string New OTP
     * @throws Exception
     */
    public function resend(string $identifier, string $type = 'email'): string
    {
        // Invalidate previous OTPs
        OtpVerification::where('identifier', $identifier)
            ->where('type', $type)
            ->where('is_verified', false)
            ->update(['expires_at' => now()]);

        return $this->generate($identifier, $type);
    }

    /**
     * Hash OTP for storage
     * 
     * @param string $otp Plain OTP
     * @return string Hashed OTP
     */
    private function hashOtp(string $otp): string
    {
        return hash('sha256', $otp . config('app.key'));
    }

    /**
     * Verify OTP hash
     * 
     * @param string $otp Plain OTP
     * @param string $hash Hashed OTP
     * @return bool Match status
     */
    private function verifyOtpHash(string $otp, string $hash): bool
    {
        return hash_equals($this->hashOtp($otp), $hash);
    }

    /**
     * Mask identifier for logging
     * 
     * @param string $identifier Email or phone
     * @return string Masked identifier
     */
    private function maskIdentifier(string $identifier): string
    {
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            // Mask email: user@example.com -> u***@e***.com
            $parts = explode('@', $identifier);
            $username = substr($parts[0], 0, 1) . str_repeat('*', strlen($parts[0]) - 1);
            $domain = substr($parts[1], 0, 1) . str_repeat('*', strlen($parts[1]) - 1);
            return $username . '@' . $domain;
        } else {
            // Mask phone: 1234567890 -> 12345*****
            return substr($identifier, 0, 5) . str_repeat('*', strlen($identifier) - 5);
        }
    }

    /**
     * Clean expired OTPs
     * 
     * @return int Number of cleaned records
     */
    public function cleanExpired(): int
    {
        $deleted = OtpVerification::where('expires_at', '<', now())
            ->orWhere(function ($query) {
                $query->where('is_verified', true)
                    ->where('verified_at', '<', now()->subDays(7));
            })
            ->delete();

        return $deleted;
    }
}

