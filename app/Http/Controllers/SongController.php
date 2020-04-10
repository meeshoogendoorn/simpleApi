<?php

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
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
}
