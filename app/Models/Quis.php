<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Override;

class Quis extends Model
{
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quis extends Model
{
    use HasFactory;

>>>>>>> 62312ce (Perbaikan kategori)
    protected $fillable = [
        'kode_kuis',
        'kelas_id',
        'kategori_id',
        'pertanyaan',
        'gambar',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban',
    ];

<<<<<<< HEAD
    #[Override]
    protected static function booted()
    {
        static::creating(function ($quis) {

            $nomorKuis = (self::max('id') ?? 0) + 1;

            $quis->kode_kuis = 'KUIS-' .
                str_pad($nomorKuis, 4, '0', STR_PAD_LEFT);
        });
    }

    #[Override]
    public function getRouteKeyName(): string
    {
        return 'kode_kuis';
    }

=======
    // Relasi Quis ke Kelas
>>>>>>> 62312ce (Perbaikan kategori)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

<<<<<<< HEAD
=======
    // Relasi Quis ke Kategori
>>>>>>> 62312ce (Perbaikan kategori)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
