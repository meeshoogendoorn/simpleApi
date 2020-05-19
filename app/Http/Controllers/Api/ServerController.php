<?php

namespace App\Http\Controllers\Api;

use App\Restart;
use App\Server;
use App\Song;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServerController
{
    public function connect(Request $request)
    {
        $request->validate([
            "server_name" => "required",
        ]);

        $key = Str::random(80);

        $server = new Server();
        $server->server_name = $request->get("server_name");
        $server->key = $key;
        $server->save();

        return response()->json(["success" => true, "message" => "success", "key" => $key]);
    }

    public function getApiKey(Request $request)
    {
        $key = $request->get("key");
        $server = Server::where("key", "=", $key)->first();
        if(empty($server->info->api_key))
            return response()->json(["success" => false, "message" => "Api Key not set"]);
        return response()->json(["success" => true, "data" => $server->info->api_key]);
    }

    public function getTracks(Request $request, $tracks = [])
    {
        $key = $request->get("key");
        $server = Server::where("key", "=", $key)->first();

        if(empty($server))
            return response()->json(["success" => false, "message" => "Server identity not found"])->setStatusCode(404);

        foreach($server->sources as $source) {
            $track = $source->song->uri;
            $trackId = $source->song->id;
            array_push($tracks, ["track" => $track, "id" => $trackId]);
        }

        $success = true;
        if(empty($tracks))
            $success = "empty";
        return response()->json(["success" => $success, "data" => $tracks]);
    }

    public function getRestart(Request $request)
    {
        $key = $request->get("key");

        $server = Server::where("key", "=", $key)->first();

        foreach($server->restarts as $restart){
            if($restart->restart){
                $restart->restart = false;
                $restart->save();
                return response()->json(["restart" => true]);
            }
        }

        return response()->json(["restart" => false]);
    }

    public function getServerInfo(Request $request)
    {
        $key = $request->get("key");

        $server = Server::where("key", "=", $key)->first();

        return response()->json([
            "success" => true,
            "data" => [
                "players" => (empty($server->info->players) ? 12 : $server->info->players),
                "max_play_time" => (empty($server->info->max_play_time) ? 400 : $server->info->max_play_time)
            ]
        ]);
    }

    public function updateLiveController(Request $request)
    {
        $id = $request->get('song');
        $song = Song::findOrFail($id);
        $song->updated_at = Carbon::now();
        $song->save();

        return response()->json(["success" => true, "data" => "Updated"]);
    }
}
