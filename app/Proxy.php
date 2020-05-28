<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    protected $table = "proxys";

    protected $fillable = ["proxy_id", "version", "ip", "host", "port", "user", "pass", "type", "country", "date", "date_end", "descr", "active", "checked"];
}
