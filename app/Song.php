<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends BasicExtension
{
    protected $table = "songs";

    protected $fillable = ["title", "uri", "length"];

    public function sources()
    {
        return $this->hasMany("App\Source");
    }

    public function owners()
    {
        return $this->hasMany("App\TrackOwner", "song_id", "id");
    }
}
