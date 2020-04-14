<?php

namespace App\Http\Controllers;

use App\Song;
use App\Source;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $totalStreams = DB::table("songs")->sum("streams");
        $totalSongs = DB::table("songs")->count();
        $totalServers = DB::table("servers")->count();
        $totalSources = DB::table("sources")->count();
        $sources = Source::latest()->take(5)->get();
        $songs = Song::orderBy("streams", "desc")->limit(10)->get();

        return view('dashboard', compact("totalStreams", "totalSongs", "totalServers", "totalSources","sources", "songs"));
    }
}
