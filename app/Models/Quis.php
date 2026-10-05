<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Quis extends Model
{
    protected $fillable = [
        'kode_kuis',
        'kelas_id',
        'kategori_id',
        'pertanyaan',
        'gambar',
        'audio',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban',
    ];

    protected $casts = [
        'gambar' => 'array',
    ];

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

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
