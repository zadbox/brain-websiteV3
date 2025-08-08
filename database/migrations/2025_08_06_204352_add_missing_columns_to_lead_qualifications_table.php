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
        Schema::table('lead_qualifications', function (Blueprint $table) {
            // Add missing columns for analytics
            $table->string('authority_level')->nullable()->after('budget_range');
            $table->string('industry')->nullable()->after('company_size');
            $table->json('needs_analysis')->nullable()->after('industry');
            $table->boolean('sales_ready')->default(false)->after('lead_score');
            $table->decimal('conversation_quality', 3, 1)->nullable()->after('sales_ready');
            $table->decimal('model_confidence', 4, 3)->nullable()->after('conversation_quality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_qualifications', function (Blueprint $table) {
            $table->dropColumn([
                'authority_level',
                'industry', 
                'needs_analysis',
                'sales_ready',
                'conversation_quality',
                'model_confidence'
            ]);
        });
    }
};
