<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Security Log Model
 * 
 * Immutable security audit logs
 * 
 * @package App\Models
 */
class SecurityLog extends Model
{
    use HasFactory;

    /**
     * Disable timestamps (immutable logs)
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'member_id',
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'request_data',
        'response_data',
        'status',
        'risk_level',
        'logged_at',
    ];

    /**
     * Get the attributes that should be cast
     */
    protected function casts(): array
    {
        return [
            'request_data' => 'array',
            'response_data' => 'array',
            'logged_at' => 'datetime',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($log) {
            $log->logged_at = now();
        });
    }

    /**
     * Relationship: Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope: High risk
     */
    public function scopeHighRisk($query)
    {
        return $query->where('risk_level', 'high');
    }

    /**
     * Scope: Failed actions
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}

