<?php

namespace App\Models;

use App\Traits\EncryptsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

/**
 * Member Model
 * 
 * Represents an individual membership application
 * All sensitive data is encrypted using AES-256
 * 
 * @package App\Models
 */
class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, EncryptsAttributes, SoftDeletes;

    /**
     * Encrypted attributes (AES-256)
     */
    protected $encrypted = [
        'cnic',
        'phone',
        'email',
        'address',
    ];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'membership_id',
        'full_name',
        'cnic',
        'phone',
        'email',
        'address',
        'city',
        'district',
        'province',
        'gender',
        'region',
        'password',
        'status',
        'approved_at',
        'expires_at',
        'certificate_path',
        'certificate_generated_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_enabled_at',
    ];

    /**
     * The attributes that should be hidden for serialization
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'expires_at' => 'datetime',
            'certificate_generated_at' => 'datetime',
            'two_factor_enabled_at' => 'datetime',
            'password' => 'hashed', // Uses Argon2id
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate full_name when saving
        static::saving(function ($member) {
            if (!empty($member->first_name) && !empty($member->last_name)) {
                $member->full_name = trim($member->first_name . ' ' . $member->last_name);
            }
        });

        // Generate membership ID before creating
        static::creating(function ($member) {
            if (empty($member->membership_id)) {
                $member->membership_id = static::generateMembershipId();
            }

            // Detect gender and region from CNIC
            if (!empty($member->cnic)) {
                $member->gender = static::detectGenderFromCnic($member->cnic);
                $member->region = static::detectRegionFromCnic($member->cnic);
            }
        });
    }

    /**
     * Generate unique membership ID
     * Format: IND-YYYYMMDD-XXXXXX
     * 
     * @return string
     */
    public static function generateMembershipId(): string
    {
        do {
            $date = now()->format('Ymd');
            $random = strtoupper(Str::random(6));
            $membershipId = "IND-{$date}-{$random}";
        } while (static::where('membership_id', $membershipId)->exists());

        return $membershipId;
    }

    /**
     * Detect gender from CNIC
     * CNIC format: XXXXX-XXXXXXX-X
     * Last digit: 1-5 = Male, 6-9 = Female
     * 
     * @param string $cnic CNIC number
     * @return string 'male' or 'female'
     */
    public static function detectGenderFromCnic(string $cnic): string
    {
        // Remove dashes and spaces
        $cnic = preg_replace('/[-\s]/', '', $cnic);
        
        if (strlen($cnic) < 13) {
            return 'unknown';
        }

        $lastDigit = (int) substr($cnic, -1);
        
        // Pakistani CNIC: Last digit 1-5 = Male, 6-9 = Female
        if ($lastDigit >= 1 && $lastDigit <= 5) {
            return 'male';
        } elseif ($lastDigit >= 6 && $lastDigit <= 9) {
            return 'female';
        }

        return 'unknown';
    }

    /**
     * Detect region from CNIC
     * First 5 digits represent region code
     * 
     * @param string $cnic CNIC number
     * @return string Region code
     */
    public static function detectRegionFromCnic(string $cnic): string
    {
        // Remove dashes and spaces
        $cnic = preg_replace('/[-\s]/', '', $cnic);
        
        if (strlen($cnic) < 5) {
            return 'unknown';
        }

        $regionCode = substr($cnic, 0, 5);
        
        // Map region codes (simplified - expand based on actual requirements)
        $regions = [
            '37401' => 'Islamabad',
            '42101' => 'Karachi',
            '35200' => 'Lahore',
            '54000' => 'Rawalpindi',
            // Add more region mappings
        ];

        return $regions[$regionCode] ?? 'unknown';
    }

    /**
     * Get masked CNIC for display
     * 
     * @return string
     */
    public function getMaskedCnicAttribute(): string
    {
        $cnic = $this->cnic;
        if (strlen($cnic) < 5) {
            return '*****';
        }
        return substr($cnic, 0, 5) . str_repeat('*', strlen($cnic) - 5);
    }

    /**
     * Get masked phone for display
     * 
     * @return string
     */
    public function getMaskedPhoneAttribute(): string
    {
        $phone = $this->phone;
        if (strlen($phone) < 4) {
            return '****';
        }
        return substr($phone, 0, 4) . str_repeat('*', strlen($phone) - 4);
    }

    /**
     * Get masked email for display
     * 
     * @return string
     */
    public function getMaskedEmailAttribute(): string
    {
        $email = $this->email;
        if (strpos($email, '@') === false) {
            return '****@****';
        }
        [$username, $domain] = explode('@', $email);
        $maskedUsername = substr($username, 0, 1) . str_repeat('*', strlen($username) - 1);
        $maskedDomain = substr($domain, 0, 1) . str_repeat('*', strlen($domain) - 1);
        return $maskedUsername . '@' . $maskedDomain;
    }

    /**
     * Check if member is approved
     * 
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if membership is expired
     * 
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if 2FA is enabled
     * 
     * @return bool
     */
    public function hasTwoFactorEnabled(): bool
    {
        return !empty($this->two_factor_secret) && !empty($this->two_factor_enabled_at);
    }

    /**
     * Relationship: Member documents
     */
    public function documents()
    {
        return $this->hasMany(MemberDocument::class);
    }

    /**
     * Relationship: OTP verifications
     */
    public function otpVerifications()
    {
        return $this->hasMany(OtpVerification::class, 'identifier', 'email');
    }

    /**
     * Relationship: Security logs
     */
    public function securityLogs()
    {
        return $this->hasMany(SecurityLog::class);
    }

    /**
     * Relationship: Activity logs
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}

