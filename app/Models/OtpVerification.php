<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * OTP Verification Model
 * 
 * Stores OTP records for email/SMS verification
 * 
 * @package App\Models
 */
class OtpVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'identifier',
        'type',
        'otp_code',
        'purpose',
        'expires_at',
        'attempts',
        'is_verified',
        'verified_at',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the attributes that should be cast
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'is_verified' => 'boolean',
            'attempts' => 'integer',
        ];
    }

    /**
     * Scope: Verified OTPs
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope: Unverified OTPs
     */
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    /**
     * Scope: Valid (not expired)
     */
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Scope: Expired
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }
}

