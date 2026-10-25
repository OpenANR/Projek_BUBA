<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'slug',
        'kelas_id',
    ];

    // Relasi kategori dengan materi
    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    // Relasi kategori dengan kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}