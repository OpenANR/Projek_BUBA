<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas'
    ];

    public function siswas()
    {
        return $this->hasMany(User::class, 'kelas_id')->where('role', 'siswa');
    }

    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }
}