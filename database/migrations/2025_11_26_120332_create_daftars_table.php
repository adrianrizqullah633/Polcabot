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
        Schema::create('daftar_knowledge', function (Blueprint $table) {
            $table->id();
            $table->text('question');      // Kolom untuk pertanyaan
            $table->text('answer');        // Kolom untuk jawaban
            $table->string('source', 500); // Kolom untuk URL sumber
            $table->timestamps();          // Kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_knowledge');
    }
};