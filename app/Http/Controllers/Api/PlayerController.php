<?php

namespace App\Http\Controllers\API;

use App\Player;
use Illuminate\Http\Request;

class PlayerController
{
    public function createPlayer(Request $request)
    {
        try {
            $player = new Player($request->all());
            $player->save();
        } catch (\Exception $e) {
            return response()->json(["success" => false, "message" => $e->getMessage()]);
        }

        return response()->json(["success" => true, "data" => $request->all()]);
    }
}
