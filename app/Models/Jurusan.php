<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusans';
    protected $fillable = [
        'nama',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'jurusan_id');
    }

    public function prodis()
    {
        return $this->hasMany(Prodi::class, 'jurusan_id');
    }
}
