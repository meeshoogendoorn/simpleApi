<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("connect", "Api\ServerController@connect");
Route::get("tracks", "Api\ServerController@getTracks");
Route::post("track/stream", "Api\TrackController@addStream");
Route::post("track/streams/multiple", "Api\TrackController@addMultipleStreamsOnTrack");
Route::get("track/length", "Api\TrackController@getTrackLength");
Route::get("restart", "Api\ServerController@getRestart");
Route::get("info", "Api\ServerController@getServerInfo");
Route::get("proxy6/key", "Api\ServerController@getApiKey");
Route::get("settings", "Api\ConfigController@getSettings");
