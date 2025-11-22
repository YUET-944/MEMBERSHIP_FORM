<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('security_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type', 50)->index();
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_type', 50)->nullable(); // 'member', 'admin'
            $table->string('ip_address', 45)->index();
            $table->text('user_agent')->nullable();
            $table->text('description');
            $table->json('metadata')->nullable();
            $table->boolean('resolved')->default(false)->index();
            $table->timestamp('resolved_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->timestamps();

            // Composite indexes
            $table->index(['severity', 'resolved', 'created_at']);
            $table->index(['event_type', 'created_at']);
            $table->index(['user_id', 'user_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_events');
    }
};

