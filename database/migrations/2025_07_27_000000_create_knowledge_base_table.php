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
        Schema::create('knowledge_base', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category', 100)->index(); // ex: faq, qualification, objection
            $table->text('question');
            $table->text('answer');
            $table->json('keywords')->nullable();
            $table->json('context')->nullable();
            $table->binary('embedding')->nullable(); // Pour stocker le vecteur d'embedding
            $table->integer('priority')->default(1)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_base');
    }
}; 