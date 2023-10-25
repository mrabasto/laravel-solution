<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'year',
        'name',
        'sales',
        'release_date'
    ];

    
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
