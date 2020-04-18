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
        $totalStreams = $this->getStreams();
        $totalSongs = $this->getSongCount();
        $totalServers = $this->getServerCount();
        $totalSources = $this->getSourcesCount();
        $sources = $this->getSources();
        $songs = $this->getSongs();

        return view('dashboard', compact("totalStreams", "totalSongs", "totalServers", "totalSources","sources", "songs"));
    }

    public function getServerCount()
    {
        if(auth()->user()->admin)
            return DB::table("servers")->count();

        $tempServers = Server::all();
        $servers = [];
        foreach($tempServers as $server) {
            if ($server->hasOwner()) {
                array_push($servers, $server);
            }
        }
        return count($servers);
    }

    public function getSongs()
    {
        if(auth()->user()->admin)
            return Song::orderBy("streams", "desc")->limit(10)->get();

        $tempSongs = Song::orderBy("streams", "desc")->get();
        $songs = [];
        foreach($tempSongs as $song) {
            if(count($songs) > 5)
                return $songs;

            if ($song->hasOwner()) {
                array_push($songs, $song);
            }
        }

        return $songs;
    }

    public function getStreams()
    {
        if(auth()->user()->admin)
            return DB::table("songs")->sum("streams");

        $tempSongs = Song::all();
        $songs = [];

        foreach($tempSongs as $song){
            if($song->hasOwner()){
                array_push($songs, $song);
            }
        }

        $streams = 0;

        foreach($songs as $song)
            $streams+=$song->streams;

        return $streams;
    }

    public function getSongCount()
    {
        if(auth()->user()->admin)
            return DB::table("songs")->count();

        $tempSongs = Song::all();
        $songs = [];

        foreach($tempSongs as $song){
            if($song->hasOwner()){
                array_push($songs, $song);
            }
        }

        return count($songs);
    }

    public function getSourcesCount()
    {
        if(auth()->user()->admin)
            return DB::table("sources")->count();

        $tempSources = Source::all();
        $sources = [];
        foreach ($tempSources as $source){
            if($source->server->hasOwner()){
                array_push($sources, $source);
            }
        }

        return count($sources);
    }

    public function getSources()
    {
        $tempSources = Source::all();
        $sources = [];
        foreach($tempSources as $source){
            if(count($sources) > 5)
                return $sources;
            $source->song->permission = false;
            if($source->song->hasOwner()){
                $source->song->permission = true;
            }

            if($source->server->hasOwner() || auth()->user()->admin) {
                array_push($sources, $source);
            }
        }

        return $sources;
    }
}
