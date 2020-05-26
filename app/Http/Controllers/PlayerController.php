<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $count = Player::all()->count();

        return view("players.create", compact("count"));
    }

    public function createBulk()
    {
        $count = Player::all()->count();

        return view("players.special", compact("count"));
    }

    public function store(Request $request)
    {
        if($request->has('bulk')){
            $players = $request->get("players");
            $players = explode("\n", str_replace("\r", "", $players));
            foreach($players as $player){
                try {
                    $player = explode(";", $player);
                    $newPlayer = new Player(["email" => $player[0], "uname" => $player[0], "passw" => $player[1]]);
                    $newPlayer->save();
                } catch (\Exception $e){
                    continue;
                }
            }
            return redirect()->back()->with("success", "Players Saved");
        }
        $player = new Player($request->all());
        $player->save();

        return redirect()->back()->with("success", "Player saved");
    }
}
