<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackOwner extends Model
{
    protected $table = "track_owners";

    protected $fillable = ["user_id", "song_id"];

    public function song()
    {
        return $this->hasOne("App\Song", "id", "song_id");
    }
}
