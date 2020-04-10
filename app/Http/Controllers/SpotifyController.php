<?php

namespace App\Http\Controllers;

use Rennokki\Larafy\Larafy;

class SpotifyController extends Controller
{
    private  $spotifyClientSecret = "9a6b9a745c1742dbaa148e77b419200d";
    private  $spotifyClientPublic = "b7f8b156b4764323b76c8f02303d44ea";

    public function __construct()
    {
//        $this->middleware("auth");
    }

    public function searchArtist($artist)
    {
        $api = new Larafy($this->spotifyClientPublic, $this->spotifyClientSecret);
        try {
            $results =  $api->searchArtists($artist);
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            // invalid ID & Secret provided
            $results =  $e->getAPIResponse(); // Get the JSON API response.
        }

        return response()->json($results);
    }

    public function searchSong($song)
    {
        $api = new Larafy($this->spotifyClientPublic, $this->spotifyClientSecret);
        try {
            $results =  $api->searchTracks($song);
        } catch(\Rennokki\Larafy\Exceptions\SpotifyAuthorizationException $e) {
            // invalid ID & Secret provided
            $results =  $e->getAPIResponse(); // Get the JSON API response.
        }

        return response()->json($results);
    }
}
