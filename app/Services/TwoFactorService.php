<?php

namespace App\Services;

use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

/**
 * Two-Factor Authentication Service
 * 
 * Implements TOTP (Time-based One-Time Password) using Google2FA
 * Supports Google Authenticator, Microsoft Authenticator, Authy
 * 
 * @package App\Services
 */
class TwoFactorService
{
    /**
     * Google2FA instance
     */
    private Google2FA $google2fa;

    /**
     * 2FA issuer name
     */
    private string $issuer;

    /**
     * Initialize 2FA service
     */
    public function __construct()
    {
        $this->google2fa = new Google2FA();
        $this->issuer = config('app.two_factor_issuer', 'National Membership System');
    }

    /**
     * Generate secret key for user
     * 
     * @param string $email User email
     * @return string Secret key
     */
    public function generateSecret(string $email): string
    {
        return $this->google2fa->generateSecretKey(32);
    }

    /**
     * Generate QR code URL for authenticator app
     * 
     * @param string $email User email
     * @param string $secret Secret key
     * @return string QR code URL
     */
    public function getQrCodeUrl(string $email, string $secret): string
    {
        return $this->google2fa->getQRCodeUrl(
            $this->issuer,
            $email,
            $secret
        );
    }

    /**
     * Generate QR code for member
     * 
     * @param mixed $member Member model
     * @return string QR code URL
     */
    public function generateQRCode($member): string
    {
        $secret = $this->generateSecret($member->email);
        session()->put('2fa_secret', $secret);
        return $this->getQrCodeUrl($member->email, $secret);
    }

    /**
     * Generate TOTP code (for testing)
     * 
     * @param string $secret Secret key
     * @return string TOTP code
     */
    public function generateCode(string $secret): string
    {
        try {
            if (strlen($secret) > 32) {
                $secret = decrypt($secret);
            }
            return $this->google2fa->getCurrentOtp($secret);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Verify TOTP code
     * 
     * @param string $secret User's secret key (encrypted)
     * @param string $code TOTP code from authenticator app
     * @return bool Verification status
     */
    public function verifyCode(string $secret, string $code): bool
    {
        try {
            // Decrypt secret if encrypted
            if (strlen($secret) > 32) {
                $secret = decrypt($secret);
            }
            return $this->verify($secret, $code);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Verify TOTP code (internal)
     * 
     * @param string $secret User's secret key
     * @param string $code TOTP code from authenticator app
     * @return bool Verification status
     */
    public function verify(string $secret, string $code): bool
    {
        try {
            // Allow 1 time window (30 seconds) before and after current time
            $valid = $this->google2fa->verifyKey($secret, $code, 1);

            if ($valid) {
                Log::channel('security')->info('2FA verification successful', [
                    'timestamp' => now(),
                ]);
            } else {
                Log::channel('security')->warning('2FA verification failed', [
                    'timestamp' => now(),
                ]);
            }

            return $valid;
        } catch (Exception $e) {
            Log::channel('security')->error('2FA verification error', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Generate backup recovery codes
     * 
     * @param int $count Number of codes to generate
     * @return array Recovery codes
     */
    public function generateRecoveryCodes(int $count = 10): array
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = strtoupper(bin2hex(random_bytes(4)));
        }
        session()->put('2fa_recovery_codes', $codes);
        return $codes;
    }

    /**
     * Verify recovery code
     * 
     * @param array $storedCodes Stored recovery codes
     * @param string $code Code to verify
     * @return bool|array False if invalid, array of remaining codes if valid
     */
    public function verifyRecoveryCode(array $storedCodes, string $code): bool|array
    {
        $code = strtoupper(trim($code));
        $index = array_search($code, $storedCodes);

        if ($index !== false) {
            // Remove used code
            unset($storedCodes[$index]);
            return array_values($storedCodes);
        }

        return false;
    }

    /**
     * Check if 2FA is enabled for user
     * 
     * @param mixed $user User model
     * @return bool
     */
    public function isEnabled($user): bool
    {
        return !empty($user->two_factor_secret);
    }

    /**
     * Enable 2FA for user
     * 
     * @param mixed $user User model
     * @param string $secret Secret key
     * @param array $recoveryCodes Recovery codes
     * @return bool
     */
    public function enable($user, string $secret, array $recoveryCodes = []): bool
    {
        try {
            $user->update([
                'two_factor_secret' => encrypt($secret),
                'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
                'two_factor_enabled_at' => now(),
            ]);

            Log::channel('security')->info('2FA enabled for user', [
                'user_id' => $user->id,
            ]);

            return true;
        } catch (Exception $e) {
            Log::channel('security')->error('Failed to enable 2FA', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Disable 2FA for user
     * 
     * @param mixed $user User model
     * @return bool
     */
    public function disable($user): bool
    {
        try {
            $user->update([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_enabled_at' => null,
            ]);

            Log::channel('security')->info('2FA disabled for user', [
                'user_id' => $user->id,
            ]);

            return true;
        } catch (Exception $e) {
            Log::channel('security')->error('Failed to disable 2FA', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}

