<?php

namespace App\Http\Controllers\API;

use App\Config;
use Illuminate\Http\Request;

class ConfigController
{
    public function getSettings()
    {
        $items = Config::all()->pluck("value", "key");

        return response()->json(["success" => true, "data" => $items]);
    }
}
