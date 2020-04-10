<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = "songs";

    protected $fillable = ["title", "uri", "length"];

    public function sources()
    {
        return $this->hasMany("App\Source");
    }
}
