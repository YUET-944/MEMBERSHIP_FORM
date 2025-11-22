<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Stores encrypted member documents
     */
    public function up(): void
    {
        Schema::create('member_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('document_type', [
                'cnic_front',
                'cnic_back',
                'profile_picture',
                'organization_certificate',
                'authorization_letter',
                'ntn_certificate',
                'license',
                'other'
            ]);
            $table->string('original_filename', 255);
            $table->string('stored_filename', 255); // Encrypted filename
            $table->string('file_path', 500); // Encrypted file path
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size'); // in bytes
            $table->string('file_hash', 64)->nullable(); // SHA-256 hash for integrity
            $table->boolean('is_verified')->default(false);
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            // Foreign key will be added after users table is created
            $table->timestamps();
            
            $table->index('member_id');
            $table->index('document_type');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_documents');
    }
};

