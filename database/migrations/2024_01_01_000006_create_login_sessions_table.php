<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tracks active login sessions
     */
    public function up(): void
    {
        Schema::create('login_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('session_id', 255)->unique();
            $table->string('ip_address', 45);
            $table->string('user_agent', 500)->nullable();
            $table->string('device_fingerprint', 64)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_activity_at');
            $table->timestamp('expires_at');
            $table->timestamps();
            
            $table->index('member_id');
            $table->index('session_id');
            $table->index('is_active');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_sessions');
    }
};

