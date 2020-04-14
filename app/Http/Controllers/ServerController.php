<?php

namespace App\Http\Controllers;

use App\Restart;
use App\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $servers = Server::all();

        return view("servers.index", compact("servers"));
    }

    public function restart($server_id)
    {
        $restart = new Restart();
        $restart->server_id = $server_id;
        $restart->save();

        return redirect()->back()->with("success", "Restarted server");
    }
}
