<?php

namespace App\Http\Controllers;

use App\Song;
use App\Source;
use App\TrackOwner;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $tempSongs = Song::all();
        $songs = [];

        foreach ($tempSongs as $song){
            if($this->checkOwner($song)){
                array_push($songs, $song);
            }
        }

        return view("songs.index", compact("songs"));
    }

    public function create()
    {
        return view("songs.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "uri" => "required|unique:songs",
            "length" => "required",
        ]);
        $song = new Song($request->all());
        $song->save();

        $trackOwner = new TrackOwner(["song_id" => $song->id, "user_id" => auth()->user()->id]);
        $trackOwner->save();

        return redirect()->back()->with("success", "Song saved successfully");
    }

    public function destroy($song_id)
    {
        $song = Song::findOrFail($song_id);

        if(! $this->checkOwner($song))
            return redirect()->back()->with("error", "No permission");

        $sources = Source::all()->where("song_id", "=", $song->id);
        foreach($sources as $source)
            $source->delete();
        $song->delete();

        return redirect()->back()->with("success", "Successfully deleted song");
    }

    public function edit($song_id)
    {
        $users = User::all();
        $song = Song::findOrFail($song_id);
        if(! $this->checkOwner($song))
            return redirect()->back()->with("error", "no permission");

        return view("songs.edit", compact("users", "song"));
    }

    public function setOwners($song_id, Request $request)
    {
        $song = Song::findOrFail($song_id);
        if(! $this->checkOwner($song))
            return redirect()->back()->with("error", "No permission");

        DB::table("track_owners")->where("song_id", "=", $song_id)->delete();

        $newOwners = $request->get("select-owner");

        foreach($newOwners as $owner) {
            $serverOwner = new TrackOwner(["song_id" => $song_id, "user_id" => $owner]);
            $serverOwner->save();
        }

        return redirect()->back()->with("success", "Successfully updated song owners");
    }

    public function checkOwner($song)
    {
        if(auth()->user()->admin)
            return true;
        if($song->hasOwner(auth()->user()->id, "song"))
            return true;
        return false;
    }
}
