<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quis extends Model
{
    use HasFactory;

    protected $fillable = [
    'pertanyaan',
    'kelas',
    'kategori',
    'pilihan_a',
    'pilihan_b',
    'pilihan_c',
    'pilihan_d',
    'jawaban',
    'gambar',
    ];
}
