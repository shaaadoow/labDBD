<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistVideo extends Model
{
    use HasFactory;

    //Relación con Playlist
    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    //Relación con Video
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
