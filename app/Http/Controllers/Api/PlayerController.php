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

    public function getPlayer()
    {
        $players = Player::all()->filter(function($player){ return $player->active == false; });
        if($players->isEmpty())
            return response()->json(["success" => false]);

        $player = $players->random();

        $result = [
            "uname" => $player->uname,
            "email" => $player->email,
            "passw" => $player->passw,
        ];

        $player->active = true;
        $player->save();

        return response()->json(["success" => true, "data" => $result]);
    }

    public function setPlayerInactive(Request $request)
    {
        $email = $request->get("email");
        if(empty($email))
            return response()->json(["success" => false, "data" => "Email is required"]);

        $player = Player::all()->where("email", "=", $email)->first();

        if(empty($player)){
            return response()->json(["success" => false, "data" => "player not found"]);
        }

        $player->active = false;
        $player->save();

        return response()->json(["success" => true, "data" => "Set to inactive"]);
    }
}