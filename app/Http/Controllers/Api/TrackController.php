<?php

namespace App\Http\Controllers\API;

use App\Song;
use Carbon\Carbon;
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
            DB::table("songs")
                ->where("uri", "=", $trackUri)
                ->increment("streams");

            DB::table("songs")
                ->where("uri", "=", $trackUri)
                ->update(["updated_at" => Carbon::now()]);

            return response()->json(["success" => true, "message" => "Stream count updated"]);
        } catch (\Exception $e){
            return response()->json(["success" => false]);
        }
    }

    public function getTrackLength(Request $request){
        $request->validate([
            "song" => "required"
        ]);

        $track = $request->get("song");

        try {
            $track = Song::where("uri", "=", $track)->first();
            return response()->json(["success" => true, "data" => $track->length]);
        } catch (\Exception $e){
            return response()->json(["success" => false]);
        }
    }
}
