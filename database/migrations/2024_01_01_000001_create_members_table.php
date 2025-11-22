<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates members table with encrypted fields
     * Supports Row-Level Security (RLS) for PostgreSQL
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('membership_id', 50)->unique()->index();
            $table->string('member_type', 20)->default('individual'); // individual, organization, government
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('full_name', 200)->nullable(); // Regular column, auto-populated by model
            
            // Encrypted fields (stored as encrypted text)
            $table->text('cnic')->nullable(); // AES-256 encrypted
            $table->text('phone')->nullable(); // AES-256 encrypted
            $table->text('email')->nullable(); // AES-256 encrypted
            $table->text('address')->nullable(); // AES-256 encrypted
            $table->text('permanent_address')->nullable(); // AES-256 encrypted
            
            // Profile information
            $table->string('profile_picture', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('education', 100)->nullable();
            $table->string('profession', 100)->nullable();
            
            // Address information
            $table->enum('resident_type', ['pakistani', 'other'])->default('pakistani');
            $table->string('province', 50)->nullable();
            $table->string('division', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('tehsil_city', 50)->nullable();
            $table->string('current_address', 500)->nullable();
            
            // Social media
            $table->string('facebook_url', 255)->nullable();
            $table->string('twitter_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('tiktok_url', 255)->nullable();
            
            // Volunteering preferences (JSON)
            $table->json('volunteering_preferences')->nullable();
            
            // Region detection from CNIC
            $table->string('region', 50)->nullable();
            
            // Authentication
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            
            // Membership status
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            // Certificate
            $table->string('certificate_path', 255)->nullable();
            $table->timestamp('certificate_generated_at')->nullable();
            
            // Two-Factor Authentication
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_enabled_at')->nullable();
            
            // Security
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index('status');
            $table->index('province');
            $table->index('district');
            $table->index('created_at');
        });
        
        // PostgreSQL Row-Level Security (RLS) policies
        // Note: RLS policies are commented out as they require additional setup
        // Access control is handled at the application layer via middleware
        // Uncomment and configure if you want to enable RLS:
        /*
        if (config('database.default') === 'pgsql') {
            DB::statement('ALTER TABLE members ENABLE ROW LEVEL SECURITY');
            
            // Policy: Members can only see their own data
            // This requires setting up a custom function or using session variables
            // For now, access control is handled by application middleware
        }
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'pgsql') {
            DB::statement('DROP POLICY IF EXISTS members_select_own ON members');
            DB::statement('ALTER TABLE members DISABLE ROW LEVEL SECURITY');
        }
        
        Schema::dropIfExists('members');
    }
};

