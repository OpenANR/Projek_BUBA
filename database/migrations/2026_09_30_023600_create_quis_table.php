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

            $table->string('kode_kuis')->unique();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnDelete();

            $table->text('pertanyaan');

            // Menyimpan beberapa gambar dalam bentuk JSON
            $table->json('gambar')->nullable();

            // Audio soal
            $table->string('audio')->nullable();

            $table->string('pilihan_a');
            $table->string('pilihan_b');
            $table->string('pilihan_c');
            $table->string('pilihan_d');

            $table->enum('jawaban', ['A', 'B', 'C', 'D']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quis');
    }
};
