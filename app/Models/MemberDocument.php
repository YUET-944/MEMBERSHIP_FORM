<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Member Document Model
 * 
 * Stores encrypted document information
 * 
 * @package App\Models
 */
class MemberDocument extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'member_id',
        'document_type',
        'original_filename',
        'stored_filename',
        'file_path',
        'file_size',
        'mime_type',
        'file_hash',
        'is_verified',
        'verification_notes',
        'verified_at',
        'verified_by',
    ];

    /**
     * Get the attributes that should be cast
     */
    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
            'file_size' => 'integer',
        ];
    }

    /**
     * Relationship: Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get file URL (temporary, secure)
     * 
     * @return string|null
     */
    public function getTemporaryUrl(int $expiresInMinutes = 5): ?string
    {
        if (empty($this->file_path)) {
            return null;
        }

        try {
            return \Storage::disk('local')->temporaryUrl(
                $this->file_path,
                now()->addMinutes($expiresInMinutes)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to generate temporary URL', [
                'document_id' => $this->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}

