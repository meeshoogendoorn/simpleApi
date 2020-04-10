<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController
{
    public function addStream(Request $request)
    {
        $request->validate([
            "track_uri" => "required"
        ]);

        $trackUri = $request->get("track_uri");
        try {
            DB::table("songs")->where("uri", "=", $trackUri)->increment("streams");
            return response()->json(["success" => true, "message" => "Stream count updated"]);
        } catch (\Exception $e){
            return response()->json(["success" => false]);
        }
    }
}
