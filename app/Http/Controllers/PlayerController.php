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
        return view("players.create");
    }

    public function store(Request $request)
    {
        $player = new Player($request->all());
        $player->save();

        return redirect()->back()->with("success", "Player saved");
    }
}
