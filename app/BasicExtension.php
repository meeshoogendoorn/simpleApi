<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicExtension extends Model
{
    function hasOwner(){
        try {
            return (bool)$this->owners()->where("user_id", auth()->user()->id)->count();
        } catch (\Exception $exception){
            return false;
        }
    }
}
