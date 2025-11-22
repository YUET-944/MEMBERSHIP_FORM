<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Admin users table with RBAC
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['super_admin', 'admin', 'moderator', 'viewer'])->default('viewer');
            $table->json('permissions')->nullable(); // Additional permissions
            $table->boolean('is_active')->default(true);
            
            // Two-Factor Authentication
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_enabled_at')->nullable();
            
            // Security
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->json('ip_whitelist')->nullable(); // Allowed IP addresses
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('role');
            $table->index('is_active');
        });
        
        // Add foreign key constraint to member_documents after users table is created
        if (Schema::hasTable('member_documents')) {
            Schema::table('member_documents', function (Blueprint $table) {
                $table->foreign('verified_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

