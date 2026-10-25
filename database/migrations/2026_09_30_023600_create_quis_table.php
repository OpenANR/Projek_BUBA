<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_kuis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kuis');

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('quis', function (Blueprint $table) {
            $table->id();

            $table->string('kode_kuis')->unique();

            $table->foreignId('paket_kuis_id')
                ->constrained('paket_kuis')
                ->cascadeOnDelete();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnDelete();

            $table->text('pertanyaan');

            $table->json('gambar')->nullable();

            $table->string('audio_pertanyaan')->nullable();
            $table->string('audio_pilihan_a')->nullable();
            $table->string('audio_pilihan_b')->nullable();
            $table->string('audio_pilihan_c')->nullable();
            $table->string('audio_pilihan_d')->nullable();

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
        Schema::dropIfExists('paket_kuis');
    }
};
