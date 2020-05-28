<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(["register" => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get("spotify/search/song/{song}", "SpotifyController@searchSong")->name("search.song");
Route::get("spotify/search/artist/{artist}", "SpotifyController@searchArtist")->name("search.artist");
Route::resource("songs", "SongController");
Route::resource("sources", "SourceController");
Route::resource("servers", "ServerController");
Route::resource("users", "UserController");
Route::get("/server/restart/{server_id}", "ServerController@restart")->name("server.restart");
Route::get("server/info/{server_id}", "ServerController@editServerInfo")->name("server.info.edit");
Route::put("server/info/{server_info_id}", "ServerController@updateServerInfo")->name("server.info.update");
Route::put("server/{server_id}/owners", "ServerController@setOwners")->name("servers.owners.set");
Route::put("song/{song_id}/owners", "SongController@setOwners")->name("songs.owners.set");
Route::put("song/{song_id}/streams", "SongController@setStreams")->name("songs.streams.set");
Route::get("/set/admin/{result}", "HomeController@setAdmin")->name("set.admin");
Route::resource("settings", "ConfigController");
Route::resource("players", "PlayerController");
Route::get("players/create/bulk", "PlayerController@createBulk")->name("players.create.bulk");


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::get("/proxy/index", "Proxy\BaseController@index");

