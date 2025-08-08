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
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique()->index();
            $table->string('user_ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->json('metadata')->nullable(); // Store additional context
            $table->integer('message_count')->default(0);
            $table->timestamp('started_at');
            $table->timestamp('last_activity_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('message_id')->unique();
            $table->enum('role', ['user', 'assistant', 'system']);
            $table->text('content');
            $table->json('metadata')->nullable(); // Store sources, processing time, etc.
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->foreign('session_id')->references('session_id')->on('chat_conversations')->onDelete('cascade');
        });

        Schema::create('lead_qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->enum('intent', ['information', 'quote', 'demo', 'consultation', 'support', 'partnership'])->nullable();
            $table->enum('urgency', ['low', 'medium', 'high', 'critical'])->nullable();
            $table->enum('company_size', ['startup', 'sme', 'mid_market', 'enterprise'])->nullable();
            $table->string('industry')->nullable();
            $table->string('company_name')->nullable();
            $table->json('technology_interests')->nullable(); // Array of technologies
            $table->json('pain_points')->nullable(); // Array of pain points
            $table->text('use_cases')->nullable();
            $table->enum('decision_maker_level', ['user', 'manager', 'director', 'c_level', 'owner', 'unknown'])->nullable();
            $table->string('geographic_region')->nullable();
            $table->string('timezone')->nullable();
            $table->integer('lead_score')->default(0); // 0-100
            $table->boolean('sales_ready')->default(false);
            $table->text('notes')->nullable();
            $table->integer('conversation_quality')->default(5); // 1-10
            $table->enum('follow_up_priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->float('model_confidence', 3, 2)->default(0.5); // 0.0-1.0
            $table->timestamp('qualified_at');
            $table->json('raw_qualification_data')->nullable(); // Store full qualification response
            $table->timestamps();

            $table->foreign('session_id')->references('session_id')->on('chat_conversations')->onDelete('cascade');
        });

        // Index for performance
        Schema::table('chat_conversations', function (Blueprint $table) {
            $table->index(['is_active', 'last_activity_at']);
            $table->index('started_at');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->index(['session_id', 'sent_at']);
            $table->index('role');
        });

        Schema::table('lead_qualifications', function (Blueprint $table) {
            $table->index(['sales_ready', 'lead_score']);
            $table->index(['follow_up_priority', 'qualified_at']);
            $table->index('company_size');
            $table->index('industry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_qualifications');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_conversations');
    }
};