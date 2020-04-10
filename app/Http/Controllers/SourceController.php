<?php

namespace App\Http\Controllers;

use App\Server;
use App\Song;
use App\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $sources = Source::all();

        return view("sources.index", compact("sources"));
    }

    public function create()
    {
        $servers = Server::all();
        $songs = Song::all();

        return view("sources.create", compact("servers", "songs"));
    }

    public function store(Request $request)
    {
        $source = new Source($request->all());
        $source->save();

        return redirect()->back()->with("success", "Stored source successfully");
    }

    public function destroy($source_id)
    {
        $source = Source::findOrFail($source_id);
        $source->delete();

        return redirect()->back()->with("success", "Successfully deleted source");
    }
}
