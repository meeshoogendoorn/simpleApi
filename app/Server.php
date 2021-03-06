<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends BasicExtension
{
    protected $table = "servers";

    protected $fillable = ["server_name", "key"];

    public function sources()
    {
        return $this->hasMany("App\Source");
    }

    public function restarts()
    {
        return $this->hasMany("App\Restart", "server_id", "id");
    }

    public function info()
    {
        return $this->hasOne("App\ServerInfo", "server_id", "id");
    }

    public function owners()
    {
        return $this->hasMany("App\ServerOwner", "server_id", "id");
    }


}
