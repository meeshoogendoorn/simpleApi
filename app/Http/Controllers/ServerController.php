<?php

namespace App\Http\Controllers;

use App\Restart;
use App\Server;
use App\ServerInfo;
use App\Source;
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

    public function destroy($server_id)
    {
        $server = Server::findOrFail($server_id);
        $sources = Source::where("server_id", "=", $server->id);

        foreach($sources as $source)
            $source->delete();
        $server->delete();

        return redirect()->back()->with("success", "Deleted server and its connected sources");
    }

    public function editServerInfo($server_id)
    {
        $server = Server::findOrFail($server_id);

        $info = $server->info;

        if(empty($server->info)) {
            $info = new ServerInfo(["server_id" => $server->id]);
            $info->save();
        }

        return view("server_info.edit", compact("info"));
    }


    public function updateServerInfo($server_info_id, Request $request)
    {
        $serverInfo = ServerInfo::findOrFail($server_info_id);
        if($request->has("players"))
            $serverInfo->players = $request->get("players");
        if($request->has("max_play_time"))
            $serverInfo->max_play_time = $request->get("max_play_time");

        $serverInfo->save();
        return redirect()->back()->with("success", "Succesfully updated server info");
    }
}
