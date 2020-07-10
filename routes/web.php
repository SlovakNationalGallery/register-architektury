<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
	Route::get('/', function (Request $request) {
	    $search = $request->input('search');
	    $buildings = (new \App\Models\Building)->newQuery();

	    if (!empty($search)) {
	    	$buildings = \App\Models\Building::search($search);
	    }

	    $buildings = $buildings->paginate(20);
	    return view('welcome', compact('buildings'));
	})->name('home');

    Route::get('objekty', 'BuildingController@index')->name('building.index');
	Route::get('objekt/{id}-{slug}', 'BuildingController@show')->name('building.detail');

    Route::resource('architekti', 'ArchitectController')
        ->names('architects')
        ->parameter('architekti', 'architect');

    Route::name('about.')->group(function () {
        Route::view('/oddelenie-architektury', 'department')->name('department');
        Route::view('/novinky', 'department')->name('news'); //TODO
        Route::get('publikacie', 'PublicationController@index')->name('publications');
    });
});

Route::get('styleguide', 'StyleGuideController@index')->name('styleguide');

Route::post('map/hide', function (Request $request) {
    $request->session()->put('show_map', false);
    return response(null, Response::HTTP_OK);
});

Route::post('map/show', function (Request $request) {
    $request->session()->put('show_map', true);
    return response(null, Response::HTTP_OK);
});
