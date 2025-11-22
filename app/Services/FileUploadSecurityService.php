<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\SecurityEvent;
use Exception;

/**
 * File Upload Security Service
 * 
 * Implements enterprise-grade file upload security:
 * - MIME type validation
 * - File extension validation
 * - File size limits
 * - Random filename generation
 * - Malware scanning (placeholder for integration)
 * 
 * @package App\Services
 */
class FileUploadSecurityService
{
    /**
     * Allowed MIME types for images
     */
    private array $allowedImageMimes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    /**
     * Allowed file extensions
     */
    private array $allowedExtensions = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'pdf', 'doc', 'docx',
    ];

    /**
     * Maximum file size in bytes (2MB)
     */
    private int $maxFileSize = 2097152;

    /**
     * Validate and secure file upload
     *
     * @param UploadedFile $file
     * @param string $type Type of upload (profile, document, etc.)
     * @return array ['success' => bool, 'path' => string|null, 'error' => string|null]
     */
    public function validateAndStore(UploadedFile $file, string $type = 'profile'): array
    {
        try {
            // 1. Validate file size
            if ($file->getSize() > $this->maxFileSize) {
                $this->logSecurityEvent(
                    SecurityEvent::TYPE_FILE_UPLOAD_SUSPICIOUS,
                    SecurityEvent::SEVERITY_MEDIUM,
                    ['reason' => 'File size exceeded', 'size' => $file->getSize()]
                );
                return [
                    'success' => false,
                    'error' => 'File size exceeds maximum allowed size of 2MB',
                ];
            }

            // 2. Validate file extension
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $this->allowedExtensions)) {
                $this->logSecurityEvent(
                    SecurityEvent::TYPE_FILE_UPLOAD_SUSPICIOUS,
                    SecurityEvent::SEVERITY_HIGH,
                    ['reason' => 'Invalid file extension', 'extension' => $extension]
                );
                return [
                    'success' => false,
                    'error' => 'File type not allowed. Allowed types: ' . implode(', ', $this->allowedExtensions),
                ];
            }

            // 3. Validate MIME type
            $mimeType = $file->getMimeType();
            if ($type === 'profile' && !in_array($mimeType, $this->allowedImageMimes)) {
                $this->logSecurityEvent(
                    SecurityEvent::TYPE_FILE_UPLOAD_SUSPICIOUS,
                    SecurityEvent::SEVERITY_HIGH,
                    ['reason' => 'Invalid MIME type', 'mime' => $mimeType]
                );
                return [
                    'success' => false,
                    'error' => 'Invalid file type. Only images are allowed for profile pictures.',
                ];
            }

            // 4. Verify file content matches extension (prevent extension spoofing)
            if (!$this->verifyFileContent($file, $extension)) {
                $this->logSecurityEvent(
                    SecurityEvent::TYPE_FILE_UPLOAD_SUSPICIOUS,
                    SecurityEvent::SEVERITY_CRITICAL,
                    ['reason' => 'File content mismatch', 'extension' => $extension, 'mime' => $mimeType]
                );
                return [
                    'success' => false,
                    'error' => 'File content does not match file extension. Upload rejected for security.',
                ];
            }

            // 5. Generate secure random filename
            $filename = $this->generateSecureFilename($extension);
            $directory = $this->getUploadDirectory($type);
            
            // 6. Store file with secure permissions
            $path = $file->storeAs($directory, $filename, 'private');
            
            // 7. Set secure file permissions (Unix only)
            if (file_exists(storage_path('app/private/' . $path))) {
                chmod(storage_path('app/private/' . $path), 0600); // Read/write for owner only
            }

            // 8. Optional: Malware scanning (integrate with ClamAV or similar)
            // $this->scanForMalware($path);

            return [
                'success' => true,
                'path' => $path,
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
            ];

        } catch (Exception $e) {
            Log::channel('security')->error('File upload validation failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'type' => $type,
            ]);

            return [
                'success' => false,
                'error' => 'File upload failed. Please try again.',
            ];
        }
    }

    /**
     * Verify file content matches extension
     *
     * @param UploadedFile $file
     * @param string $extension
     * @return bool
     */
    private function verifyFileContent(UploadedFile $file, string $extension): bool
    {
        $mimeType = $file->getMimeType();
        
        // Map extensions to expected MIME types
        $expectedMimes = [
            'jpg' => ['image/jpeg', 'image/jpg'],
            'jpeg' => ['image/jpeg', 'image/jpg'],
            'png' => ['image/png'],
            'gif' => ['image/gif'],
            'webp' => ['image/webp'],
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        ];

        if (!isset($expectedMimes[$extension])) {
            return false;
        }

        return in_array($mimeType, $expectedMimes[$extension]);
    }

    /**
     * Generate secure random filename
     *
     * @param string $extension
     * @return string
     */
    private function generateSecureFilename(string $extension): string
    {
        // Generate cryptographically secure random filename
        return Str::random(40) . '.' . $extension;
    }

    /**
     * Get upload directory based on type
     *
     * @param string $type
     * @return string
     */
    private function getUploadDirectory(string $type): string
    {
        return match($type) {
            'profile' => 'profile_pictures',
            'document' => 'member_documents',
            default => 'uploads',
        };
    }

    /**
     * Log security event
     *
     * @param string $eventType
     * @param string $severity
     * @param array $metadata
     * @return void
     */
    private function logSecurityEvent(string $eventType, string $severity, array $metadata = []): void
    {
        SecurityEvent::log($eventType, $severity, [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => $metadata,
        ]);
    }
}

