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
        Schema::table('organisasi_knowledge', function (Blueprint $table) {
            // Tambah kolom keywords (tipe TEXT)
            $table->text('keywords')->nullable()->after('answer');
        });
        Schema::table('jurusan_knowledge', function (Blueprint $table) {
            // Tambah kolom keywords (tipe TEXT)
            $table->text('keywords')->nullable()->after('answer');
        });
        Schema::table('daftar_knowledge', function (Blueprint $table) {
            // Tambah kolom keywords (tipe TEXT)
            $table->text('keywords')->nullable()->after('answer');
        });
        Schema::table('beasiswa_knowledge', function (Blueprint $table) {
            // Tambah kolom keywords (tipe TEXT)
            $table->text('keywords')->nullable()->after('answer');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organisasi_knowledge', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });
    }
};
