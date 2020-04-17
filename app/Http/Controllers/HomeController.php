<?php

namespace App\Http\Controllers;

use App\Server;
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
        $totalServers = $this->getServerCount();
        $totalSources = $this->getSourcesCount();
        $sources = Source::latest()->take(5)->get();
        $songs = Song::orderBy("streams", "desc")->limit(10)->get();

        return view('dashboard', compact("totalStreams", "totalSongs", "totalServers", "totalSources","sources", "songs"));
    }

    public function getServerCount()
    {
        if(auth()->user()->admin)
            return DB::table("servers")->count();

        $tempServers = Server::all();
        $servers = [];
        foreach($tempServers as $server) {
            if ($server->hasOwner(auth()->user()->id)) {
                array_push($servers, $server);
            }
        }
        return count($servers);
    }

    public function getSourcesCount()
    {
        if(auth()->user()->admin)
            return DB::table("sources")->count();

        $tempSources = Source::all();
        $sources = [];
        foreach ($tempSources as $source){
            if($source->server->hasOwner(auth()->user()->id)){
                array_push($sources, $source);
            }
        }

        return count($sources);
    }
}
