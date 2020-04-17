<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerOwner extends Model
{
    protected $table = "server_owners";

    protected $fillable = ["user_id", "server_id"];


    public function server()
    {
        return $this->hasOne("App\Server", "id", "server_id");
    }
}
