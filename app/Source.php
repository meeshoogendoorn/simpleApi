<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = "sources";

    protected $fillable = ["server_id", "song_id"];

    public function server()
    {
        return $this->belongsTo("App\Server");
    }

    public function song()
    {
        return $this->hasOne("App\Song", "id", "song_id");
    }
}
