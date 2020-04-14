<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restart extends Model
{
    protected $table = "restarts";

    protected $fillable = ["server_id", "restart"];

    public function server()
    {
        return $this->belongsTo("App\Server", "id", "server_id");
    }
}
