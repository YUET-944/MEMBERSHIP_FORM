<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Security event logs for threat monitoring
     */
    public function up(): void
    {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->string('event_type', 50); // login_attempt, brute_force, sql_injection, xss_attempt, etc.
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->text('description');
            $table->string('ip_address', 45);
            $table->string('user_agent', 500)->nullable();
            $table->string('request_url', 500)->nullable();
            $table->json('request_data')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('blocked_until')->nullable();
            $table->timestamps();
            
            $table->index('member_id');
            $table->index('event_type');
            $table->index('severity');
            $table->index('ip_address');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};

