<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKarya extends Model
{
    use HasFactory;
    protected $table = 'jenis_karyas';

    protected $fillable = [
        'nama',
    ];

    public function karyas()
    {
        return $this->hasMany(Karya::class, 'jenis_karya_id');
    }
}
