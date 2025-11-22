<?php

namespace App\Traits;

use App\Services\EncryptionService;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * EncryptsAttributes Trait
 * 
 * Automatically encrypts/decrypts model attributes
 * Uses AES-256 encryption for sensitive data
 * 
 * @package App\Traits
 */
trait EncryptsAttributes
{
    /**
     * Encryption service instance
     */
    protected ?EncryptionService $encryptionService = null;

    /**
     * Get encryption service
     * 
     * @return EncryptionService
     */
    protected function getEncryptionService(): EncryptionService
    {
        if ($this->encryptionService === null) {
            $this->encryptionService = app(EncryptionService::class);
        }
        return $this->encryptionService;
    }

    /**
     * Get encrypted attributes list
     * 
     * @return array
     */
    protected function getEncryptedAttributes(): array
    {
        return $this->encrypted ?? [];
    }

    /**
     * Boot trait
     */
    protected static function bootEncryptsAttributes(): void
    {
        // Encrypt before saving
        static::saving(function ($model) {
            $model->encryptAttributes();
        });

        // Decrypt after retrieving
        static::retrieved(function ($model) {
            $model->decryptAttributes();
        });
    }

    /**
     * Encrypt attributes before save
     */
    protected function encryptAttributes(): void
    {
        $encryptedAttributes = $this->getEncryptedAttributes();
        $encryptionService = $this->getEncryptionService();

        foreach ($encryptedAttributes as $attribute) {
            if ($this->isDirty($attribute) && !empty($this->attributes[$attribute])) {
                try {
                    // Only encrypt if not already encrypted (check if it's a valid encrypted string)
                    if (!$this->isEncrypted($this->attributes[$attribute])) {
                        $this->attributes[$attribute] = $encryptionService->encrypt($this->attributes[$attribute]);
                    }
                } catch (Exception $e) {
                    Log::channel('security')->error('Attribute encryption failed', [
                        'model' => get_class($this),
                        'attribute' => $attribute,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    /**
     * Decrypt attributes after retrieve
     */
    protected function decryptAttributes(): void
    {
        $encryptedAttributes = $this->getEncryptedAttributes();
        $encryptionService = $this->getEncryptionService();

        foreach ($encryptedAttributes as $attribute) {
            if (isset($this->attributes[$attribute]) && !empty($this->attributes[$attribute])) {
                try {
                    if ($this->isEncrypted($this->attributes[$attribute])) {
                        $this->attributes[$attribute] = $encryptionService->decrypt($this->attributes[$attribute]);
                    }
                } catch (Exception $e) {
                    Log::channel('security')->error('Attribute decryption failed', [
                        'model' => get_class($this),
                        'attribute' => $attribute,
                        'error' => $e->getMessage(),
                    ]);
                    // Set to empty on decryption failure to prevent data leakage
                    $this->attributes[$attribute] = '';
                }
            }
        }
    }

    /**
     * Check if value is encrypted
     * 
     * @param string $value Value to check
     * @return bool
     */
    protected function isEncrypted(?string $value): bool
    {
        // Laravel's encrypted strings are base64 encoded and have specific structure
        // Check if it looks like an encrypted string
        if (empty($value)) {
            return false;
        }

        // Encrypted strings are base64 encoded JSON
        $decoded = base64_decode($value, true);
        if ($decoded === false) {
            return false;
        }

        $json = json_decode($decoded, true);
        return is_array($json) && isset($json['iv']) && isset($json['value']) && isset($json['mac']);
    }

    /**
     * Get decrypted attribute value
     * 
     * @param string $key Attribute name
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        // If attribute is in encrypted list and value is encrypted, decrypt it
        if (in_array($key, $this->getEncryptedAttributes()) && !empty($value) && $this->isEncrypted($value)) {
            try {
                return $this->getEncryptionService()->decrypt($value);
            } catch (Exception $e) {
                Log::channel('security')->error('Failed to decrypt attribute on get', [
                    'attribute' => $key,
                    'error' => $e->getMessage(),
                ]);
                return '';
            }
        }
        
        return $value;
    }

    /**
     * Set attribute value
     * 
     * @param string $key Attribute name
     * @param mixed $value Value to set
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        // Don't encrypt on set, let saving event handle it
        return parent::setAttribute($key, $value);
    }
}

