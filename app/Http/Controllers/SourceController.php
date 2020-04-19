<?php

namespace App\Http\Controllers;

use App\Restart;
use App\Server;
use App\Song;
use App\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SourceController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $tempSources = Source::all();
        $sources = [];
        foreach($tempSources as $source){
            $source->song->permission = false;
            if($source->song->hasOwner()){
                $source->song->permission = true;
            }

            if($source->server->hasOwner() || auth()->user()->admin) {
                array_push($sources, $source);
            }
        }

        if(auth()->user()->admin && Session::get("admin"))
            $sources = $tempSources;

        return view("sources.index", compact("sources"));
    }

    public function create()
    {

        $tempServers = Server::all();
        $servers = [];
        foreach($tempServers as $server) {
            if ($server->hasOwner()) {
                array_push($servers, $server);
            }
        }

        if(auth()->user()->admin && Session::get("admin"))
            $servers = $tempServers;

        $tempSongs = Song::all();
        $songs = [];

        foreach ($tempSongs as $song){
            if($song->hasOwner()){
                array_push($songs, $song);
            }
        }

        if(auth()->user()->admin && Session::get("admin"))
            $songs = $tempSongs;

        return view("sources.create", compact("servers", "songs"));
    }

    public function store(Request $request)
    {
        $combinationOfSourceExists = DB::table("sources")
            ->where("song_id", "=", $request->get("song_id"))
            ->where("server_id", "=", $request->get("server_id"))
            ->exists();

        if($combinationOfSourceExists)
            return redirect()->back()->with("error", "Source combination already exists");


        $source = new Source($request->all());
        $source->save();

        $restart = new Restart();
        $restart->server_id = $request->get("server_id");
        $restart->save();

        return redirect()->back()->with("success", "Stored source successfully");
    }

    public function destroy($source_id)
    {
        $source = Source::findOrFail($source_id);
        $source->delete();

        return redirect()->back()->with("success", "Successfully deleted source");
    }
}
