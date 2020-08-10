<?php

use App\Jobs\Upstream\ImportAll;
use App\Jobs\Upstream\ResetDatabase;
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

Route::post('sync/reset', function() {
    ResetDatabase::dispatchNow();
});

Route::post('sync/start', function() {
    ImportAll::dispatchNow();
});

Route::get('search-sugestions', 'API\SearchSuggestionController@index');
