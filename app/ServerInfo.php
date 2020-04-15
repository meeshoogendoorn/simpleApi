<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerInfo extends Model
{
    protected $table = "server_info";

    protected $fillable = ["server_id", "players", "max_play_time"];

    public function server()
    {
        return $this->belongsTo("App\Server", "id", "server_id");
    }
}
