<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;  
use Override;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode_user',
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'role',
        'kelas_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    #[Override]
    protected static function booted()
    {
        static::creating(function($user) {

            $prefix = ($user->role === 'guru') ? 'TCR' : 'STD';

            do {
                $code = $prefix . '-'. Str::upper(Str::random(4));
            } while (self::where('kode_user', $code)->exists());

            $user->kode_user = $code;
        });
    }

    #[Override]
    public function getRouteKeyName()
    {
        return 'kode_user';
    }

    
}
