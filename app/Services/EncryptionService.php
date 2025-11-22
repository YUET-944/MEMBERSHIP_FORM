<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Encryption\Encrypter;
use Exception;

/**
 * AES-256 Encryption Service
 * 
 * Provides secure encryption/decryption for sensitive data
 * Uses AES-256-CBC cipher with secure key management
 * 
 * @package App\Services
 */
class EncryptionService
{
    /**
     * Encryption key (32 bytes for AES-256)
     */
    private string $encryptionKey;

    /**
     * Cipher method
     */
    private string $cipher = 'AES-256-CBC';

    /**
     * Initialize encryption service
     */
    public function __construct()
    {
        // Lazy load - only get key when needed
        $this->encryptionKey = '';
    }
    
    /**
     * Get encryption key (lazy loaded)
     */
    private function getEncryptionKeyInstance(): string
    {
        if (empty($this->encryptionKey)) {
            $this->encryptionKey = $this->getEncryptionKey();
        }
        return $this->encryptionKey;
    }

    /**
     * Get encryption key from environment or generate new one
     * 
     * @return string
     * @throws Exception
     */
    private function getEncryptionKey(): string
    {
        $key = config('app.encryption_key') ?? env('ENCRYPTION_KEY');
        
        if (empty($key)) {
            throw new Exception('Encryption key not configured. Run: php artisan encryption:generate-keys');
        }

        // Ensure key is exactly 32 bytes for AES-256
        if (strlen($key) !== 32) {
            throw new Exception('Encryption key must be exactly 32 bytes (256 bits)');
        }

        return $key;
    }

    /**
     * Encrypt sensitive data using AES-256
     * 
     * @param string $data Plain text data to encrypt
     * @return string Encrypted data (base64 encoded)
     * @throws Exception
     */
    public function encrypt(string $data): string
    {
        try {
            if (empty($data)) {
                return '';
            }

            $encrypter = new Encrypter($this->getEncryptionKeyInstance(), $this->cipher);
            $encrypted = $encrypter->encrypt($data);

            // Log encryption activity (without sensitive data)
            Log::channel('security')->info('Data encrypted', [
                'data_length' => strlen($data),
                'timestamp' => now(),
            ]);

            return $encrypted;
        } catch (Exception $e) {
            Log::channel('security')->error('Encryption failed', [
                'error' => $e->getMessage(),
                'timestamp' => now(),
            ]);
            throw new Exception('Encryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Decrypt encrypted data
     * 
     * @param string $encryptedData Encrypted data (base64 encoded)
     * @return string Decrypted plain text
     * @throws Exception
     */
    public function decrypt(string $encryptedData): string
    {
        try {
            if (empty($encryptedData)) {
                return '';
            }

            $encrypter = new Encrypter($this->getEncryptionKeyInstance(), $this->cipher);
            $decrypted = $encrypter->decrypt($encryptedData);

            // Log decryption activity
            Log::channel('security')->info('Data decrypted', [
                'data_length' => strlen($encryptedData),
                'timestamp' => now(),
            ]);

            return $decrypted;
        } catch (Exception $e) {
            Log::channel('security')->error('Decryption failed', [
                'error' => $e->getMessage(),
                'timestamp' => now(),
            ]);
            throw new Exception('Decryption failed: Invalid or corrupted data');
        }
    }

    /**
     * Encrypt file content
     * 
     * @param string $filePath Path to file
     * @return string Encrypted file content
     * @throws Exception
     */
    public function encryptFile(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new Exception('File not found: ' . $filePath);
        }

        $content = file_get_contents($filePath);
        return $this->encrypt($content);
    }

    /**
     * Decrypt file content and save
     * 
     * @param string $encryptedContent Encrypted content
     * @param string $outputPath Path to save decrypted file
     * @return bool Success status
     * @throws Exception
     */
    public function decryptFile(string $encryptedContent, string $outputPath): bool
    {
        try {
            $decrypted = $this->decrypt($encryptedContent);
            return file_put_contents($outputPath, $decrypted) !== false;
        } catch (Exception $e) {
            throw new Exception('File decryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate new encryption key
     * 
     * @return string Base64 encoded key
     */
    public static function generateKey(): string
    {
        return base64_encode(random_bytes(32));
    }

    /**
     * Rotate encryption key (for key rotation strategy)
     * 
     * @param string $oldKey Old encryption key
     * @param string $newKey New encryption key
     * @param callable $reEncryptCallback Callback to re-encrypt data
     * @return bool Success status
     */
    public function rotateKey(string $oldKey, string $newKey, callable $reEncryptCallback): bool
    {
        try {
            // Store old key temporarily
            $this->encryptionKey = $oldKey;
            
            // Execute re-encryption callback
            $reEncryptCallback($oldKey, $newKey);
            
            // Update to new key
            $this->encryptionKey = $newKey;
            
            Log::channel('security')->info('Encryption key rotated successfully');
            
            return true;
        } catch (Exception $e) {
            Log::channel('security')->error('Key rotation failed', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Hash data using SHA-256 (for non-reversible hashing)
     * 
     * @param string $data Data to hash
     * @return string SHA-256 hash
     */
    public function hash(string $data): string
    {
        return hash('sha256', $data);
    }

    /**
     * Verify hash
     * 
     * @param string $data Original data
     * @param string $hash Hash to verify
     * @return bool Match status
     */
    public function verifyHash(string $data, string $hash): bool
    {
        return hash_equals($this->hash($data), $hash);
    }
}

