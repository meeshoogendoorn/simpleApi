<?php

namespace App\Http\Controllers;

use App\Song;
use App\Source;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $songs = Song::all();

        return view("songs.index", compact("songs"));
    }

    public function create()
    {
        return view("songs.create");
    }

    public function store(Request $request)
    {
        $song = new Song($request->all());
        $song->save();

        return redirect()->back()->with("success", "Song saved successfully");
    }

    public function destroy($song_id)
    {
        $song = Song::findOrFail($song_id);
        $song->delete();

        return redirect()->back()->with("success", "Successfully deleted song");
    }
}
