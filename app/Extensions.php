<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Extensions extends Authenticatable{

    function hasRight($id, $type="server"){
        if($type === "server")
            return (bool)$this->serverOwnership()->where("server_id", $id)->count();
        elseif ($type === "song")
            return (bool) $this->songOwnership()->where("song_id", $id)->count();
        else
            return false;
    }

}
