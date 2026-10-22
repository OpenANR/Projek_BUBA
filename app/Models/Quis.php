<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
            do {
                $kode = 'KUIS-' . Str::upper(Str::random(4));
            } while (self::where('kode_kuis', $kode)->exists());

            $quis->kode_kuis = $kode;
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
