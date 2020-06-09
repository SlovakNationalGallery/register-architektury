<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
	});

	Route::get('objekt/{id}-{slug}', 'BuildingController@show')->name('building.detail');

});

Route::get('styleguide', 'StyleGuideController@index')->name('styleguide');