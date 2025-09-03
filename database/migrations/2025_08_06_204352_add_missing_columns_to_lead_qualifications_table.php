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
            // Add missing columns for analytics (only if they don't exist)
            if (!Schema::hasColumn('lead_qualifications', 'authority_level')) {
                $table->string('authority_level')->nullable()->after('budget_range');
            }
            if (!Schema::hasColumn('lead_qualifications', 'industry')) {
                $table->string('industry')->nullable()->after('company_size');
            }
            if (!Schema::hasColumn('lead_qualifications', 'needs_analysis')) {
                $table->json('needs_analysis')->nullable()->after('industry');
            }
            if (!Schema::hasColumn('lead_qualifications', 'sales_ready')) {
                $table->boolean('sales_ready')->default(false)->after('lead_score');
            }
            if (!Schema::hasColumn('lead_qualifications', 'conversation_quality')) {
                $table->decimal('conversation_quality', 3, 1)->nullable()->after('sales_ready');
            }
            if (!Schema::hasColumn('lead_qualifications', 'model_confidence')) {
                $table->decimal('model_confidence', 4, 3)->nullable()->after('conversation_quality');
            }
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
