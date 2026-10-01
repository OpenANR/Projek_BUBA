<?php

namespace App\Models;

<<<<<<< HEAD
// Model dasar dari Laravel Eloquent
use Illuminate\Database\Eloquent\Model;

// Digunakan untuk membuat kode materi secara acak
use Illuminate\Support\Str;

use Override;

// Model Kelas
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;
>>>>>>> 62312ce (Perbaikan kategori)
use App\Models\Kelas;

class Materi extends Model
{
<<<<<<< HEAD
    // =====================================================
    // FIELD YANG BOLEH DIISI MENGGUNAKAN Materi::create()
    // =====================================================
=======
>>>>>>> 62312ce (Perbaikan kategori)
    protected $fillable = [
        'kode_materi',
        'nama_materi',
        'isi_materi',
        'gambar',
        'audio',
        'kategori_id',
        'kelas_id'
    ];

<<<<<<< HEAD

    // =====================================================
    // MEMBUAT KODE MATERI OTOMATIS
    // =====================================================
    #[Override]
    protected static function booted()
    {
        // Berjalan otomatis ketika data materi akan dibuat
        static::creating(function($materi) {

            do {
                // Membuat kode seperti:
                // MTR-AB12
                $code = 'MTR-' . Str::upper(Str::random(4));

            // Memastikan kode yang dibuat belum digunakan
            } while (self::where('kode_materi', $code)->exists());

            // Menyimpan kode yang sudah dibuat
            // ke field kode_materi
=======
    #[Override]
    protected static function booted()
    {
        static::creating(function($materi) {
            do {
                $code = 'MTR-' . Str::upper(Str::random(4));
            } while (self::where('kode_materi', $code)->exists());

>>>>>>> 62312ce (Perbaikan kategori)
            $materi->kode_materi = $code;
        });
    }

<<<<<<< HEAD

    // =====================================================
    // MENGGUNAKAN kode_materi SEBAGAI ROUTE KEY
    // =====================================================
    #[Override]
    public function getRouteKeyName(): string
    {
        // Secara default Laravel menggunakan "id".
        // Di sini Laravel menggunakan "kode_materi".
        return 'kode_materi';
    }


    // =====================================================
    // RELASI MATERI DENGAN KATEGORI
    // =====================================================
    public function kategori()
    {
        // Satu materi dimiliki oleh satu kategori
        // kategori_id pada tabel materi
        // berhubungan dengan id pada tabel kategoris
        return $this->belongsTo(
            Kategori::class,
            'kategori_id'
        );
    }


    // =====================================================
    // RELASI MATERI DENGAN KELAS
    // =====================================================
    public function kelas()
    {
        // Satu materi dimiliki oleh satu kelas
        // kelas_id pada tabel materi
        // berhubungan dengan id pada tabel kelas
        return $this->belongsTo(
            Kelas::class,
            'kelas_id'
        );
=======
    #[Override]
    public function getRouteKeyName(): string
    {
        return 'kode_materi';
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
>>>>>>> 62312ce (Perbaikan kategori)
    }
}