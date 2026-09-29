<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'kelas_id',
    ];

    public function materi() {
        return $this->belongsTo(Materi::class);
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }
}
