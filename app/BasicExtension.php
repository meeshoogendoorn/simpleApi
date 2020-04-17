<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicExtension extends Model
{
    function hasOwner($id, $type="server"){
        if($type === "server")
            return (bool) $this->owners()->where("user_id", $id)->count();
        elseif ($type === "song")
            return (bool) $this->songOwnership()->where("user_id", $id)->count();
        else
            return false;
    }
}
