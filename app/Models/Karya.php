<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karya extends Model
{
    use HasFactory;
    protected $table = 'karyas';

    protected $fillable = [
        'user_id',
        'jenis_karya_id',
        'title',
        'kategori_id',
        'description',
        'source',
        'date',
        'pembimbing_id',
        'rights',
        'relation',
        'language_id',
        'coverage',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisKarya()
    {
        return $this->belongsTo(JenisKarya::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    public function files()
    {
        return $this->hasMany(KaryaFile::class, 'karya_id');
    }
}
