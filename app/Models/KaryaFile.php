<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaFile extends Model
{
    use HasFactory;
        protected $fillable = [
        'karya_id',
        'file_path',
        'format',
        'size',
        'thumbnail',
    ];
    public function karya()
    {
        return $this->belongsTo(Karya::class);
    }

}
