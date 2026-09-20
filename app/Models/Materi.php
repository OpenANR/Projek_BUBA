<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'nama_materi',
        'isi_materi',
        'gambar',
        'audio',
        'kategori_id'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
