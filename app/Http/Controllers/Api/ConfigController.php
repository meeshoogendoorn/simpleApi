<?php

namespace App\Http\Controllers\API;

use App\Config;
use Illuminate\Http\Request;

class ConfigController
{
    public function getSettings()
    {
        $items = Config::all();
        $result = [];

        foreach($items as $item) {
            if(strpos($item->value, ", ") !== false)
                $item->value = explode(", ", $item->value);
            $result[$item->key] = $item->value;
        }

        return response()->json(["success" => true, "data" => $result]);
    }
}
