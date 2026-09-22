<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;

class Materi extends Model
{
    protected $fillable = [
        'kode_materi',
        'nama_materi',
        'isi_materi',
        'gambar',
        'audio',
        'kategori_id'
    ];

    #[Override]
    protected static function booted()
    {
        static::creating(function($materi) {
            do {
                $code = 'MTR-' . Str::upper(Str::random(4));
            } while (self::where('kode_materi', $code)->exists());

            $materi->kode_materi = $code;
        });
    }

    #[Override]
    public function getRouteKeyName(): string
    {
        return 'kode_materi';
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
