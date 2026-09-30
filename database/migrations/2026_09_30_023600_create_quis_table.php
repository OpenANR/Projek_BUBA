<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quis', function (Blueprint $table) {
            $table->id();

            // Kode kuis
            $table->string('kode_kuis')->unique();

            // Relasi langsung ke tabel kelas
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            // Relasi langsung ke tabel kategori
            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnDelete();

            // Pertanyaan
            $table->text('pertanyaan');

            // Gambar soal
            $table->string('gambar')->nullable();

            // Pilihan jawaban
            $table->string('pilihan_a');
            $table->string('pilihan_b');
            $table->string('pilihan_c');
            $table->string('pilihan_d');

            // Jawaban benar
            $table->enum('jawaban', ['A', 'B', 'C', 'D']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quis');
    }
};
