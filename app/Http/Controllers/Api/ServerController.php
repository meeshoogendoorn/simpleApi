<?php

namespace App\Http\Controllers\Api;

use App\Server;
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

    public function getTracks(Request $request, $tracks = [])
    {
        $key = $request->get("key");
        $server = Server::where("key", "=", $key)->first();

        if(empty($server))
            return response()->json(["success" => false, "message" => "Server identity not found"])->setStatusCode(404);

        foreach($server->sources as $source) {
            $track = $source->song->uri;
            array_push($tracks, $track);
        }

        $success = true;
        if(empty($tracks))
            $success = "empty";
        return response()->json(["success" => $success, "data" => $tracks]);
    }
}
