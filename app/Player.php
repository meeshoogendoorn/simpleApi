<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = "players";

    protected $fillable = ["uname", "email", "passw", "active", "proxy_id"];

    public function get_proxy()
    {
        return $this->hasOne("App\Proxy", "proxy_id", "proxy_id");
    }
}
