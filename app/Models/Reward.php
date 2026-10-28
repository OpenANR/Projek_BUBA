<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = 'rewards';

    protected $fillable = [
        'user_id',
        'quis_id',
        'jumlah_benar',
        'jumlah_salah',
        'skor',
        'jumlah_bintang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quis()
    {
        return $this->belongsTo(Quis::class, 'quis_id');
    }
}
