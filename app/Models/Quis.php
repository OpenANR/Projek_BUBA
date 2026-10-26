<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;

class Quis extends Model
{
    protected $table = 'quis';

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
        'audio_pertanyaan',
        'audio_pilihan_a',
        'audio_pilihan_b',
        'audio_pilihan_c',
        'audio_pilihan_d',
    ];

    protected $casts = [
        'gambar' => 'array',
    ];

    #[Override]
    protected static function booted()
    {
        static::creating(function ($quis) {
            if (empty($quis->kode_kuis)) {
                do {
                    $kode = 'KUIS-' . Str::upper(Str::random(4));
                } while (self::where('kode_kuis', $kode)->exists());

                $quis->kode_kuis = $kode;
            }
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
