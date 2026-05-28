<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'nim',
        'nip',
        'email',
        'password',
        'jenis_kelamin',
        'angkatan',
        'jurusan_id',
        'prodi_id',
        'role',
        'verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function karyas()
    {
        return $this->hasMany(Karya::class, 'user_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    // Mutator untuk NIM - set null jika role bukan user atau bernilai "0"
    public function setNimAttribute($value)
    {
        $role = $this->role ?? ($this->attributes['role'] ?? null);
        if ($value === '0' || empty($value) || ($role !== null && $role !== 'user')) {
            $this->attributes['nim'] = null;
        } else {
            $this->attributes['nim'] = $value;
        }
    }

    // Mutator untuk NIP - set null jika role bukan admin atau bernilai "0"
    public function setNipAttribute($value)
    {
        $role = $this->role ?? ($this->attributes['role'] ?? null);
        if ($value === '0' || empty($value) || ($role !== null && $role !== 'admin')) {
            $this->attributes['nip'] = null;
        } else {
            $this->attributes['nip'] = $value;
        }
    }
}
