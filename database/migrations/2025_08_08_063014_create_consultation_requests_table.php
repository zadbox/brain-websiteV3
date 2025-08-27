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
        Schema::create('consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('preferred_contact', ['email', 'phone', 'both'])->default('email');
            $table->enum('preferred_time', ['morning', 'afternoon', 'evening', 'flexible'])->default('flexible');
            $table->enum('status', ['pending', 'scheduled', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('industry')->nullable();
            $table->enum('request_type', ['consultation', 'demo', 'quote', 'general'])->default('consultation');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_requests');
    }
};
