<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'slug',
        'kelas_id',
    ];

    public function materi() {
        return $this->hasMany(Materi::class);
    }

    #[Override]
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($kategori){
            if(empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama_kategori);
            }
        });
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }
}
