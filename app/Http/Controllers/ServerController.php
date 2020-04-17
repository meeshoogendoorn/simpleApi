<?php

namespace App\Http\Controllers;

use App\Restart;
use App\Server;
use App\ServerInfo;
use App\ServerOwner;
use App\Source;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServerController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $tempServers = Server::all();
        $servers = [];
        foreach($tempServers as $server) {
            if ($server->hasOwner(auth()->user()->id)) {
                array_push($servers, $server);
            }
        }

        if(auth()->user()->admin)
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

        if(! $this->checkOwner($server))
            return redirect()->back()->with("error", "No access to delete this server");

        DB::table("sources")->where("server_id", "=", $server->id)->delete();

        $server->delete();

        return redirect()->back()->with("success", "Deleted server and its connected sources");
    }

    public function editServerInfo($server_id)
    {
        $server = Server::findOrFail($server_id);

        if(! $this->checkOwner($server))
            return redirect()->back()->with("error", "No access to delete this server");

        $users = User::all();

        $info = $server->info;

        if(empty($server->info)) {
            $info = new ServerInfo(["server_id" => $server->id]);
            $info->save();
        }

        return view("server_info.edit", compact("info", "users"));
    }


    public function updateServerInfo($server_info_id, Request $request)
    {
        $serverInfo = ServerInfo::findOrFail($server_info_id);
        $server = Server::findOrFail($serverInfo->server_id);
        if(! $this->checkOwner($server))
            return redirect()->back()->with("error", "No access to delete this server");

        if($request->has("players"))
            $serverInfo->players = $request->get("players");
        if($request->has("max_play_time"))
            $serverInfo->max_play_time = $request->get("max_play_time");

        $serverInfo->save();
        return redirect()->back()->with("success", "Succesfully updated server info");
    }

    public function setOwners($server_id, Request $request)
    {
        if(! auth()->user()->admin)
            return redirect()->back()->with("error", "No permission");

        DB::table("server_owners")->where("server_id", "=", $server_id)->delete();

        $newOwners = $request->get("select-owner");

        foreach($newOwners as $owner) {
            $serverOwner = new ServerOwner(["server_id" => $server_id, "user_id" => $owner]);
            $serverOwner->save();
        }

        return redirect()->back()->with("success", "Successfully updated server owners");
    }

    public function checkOwner($server)
    {
        if(auth()->user()->admin)
            return true;
        if(! $server->hasOwner(auth()->user()->id))
            return false;
        return true;
    }
}
