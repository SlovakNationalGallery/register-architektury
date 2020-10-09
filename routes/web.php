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
	Route::get('/', 'HomeController@index')->name('home');

    Route::get('objekty', 'BuildingController@index')->name('building.index');
	Route::get('objekt/{id}-{slug}', 'BuildingController@show')->name('building.detail');

    Route::resource('architekti', 'ArchitectController')
        ->names('architects')
        ->parameter('architekti', 'architect');

    Route::resource('kolekcie', 'CollectionController')
        ->names('collections')
        ->parameter('kolekcie', 'collection');

    Route::name('about.')->group(function () {
        Route::view('/oddelenie-architektury', 'department')->name('department');
        Route::resource('novinky', 'ArticleController')->names('articles')
            ->parameter('novinky', 'article');
        Route::resource('projekty', 'ProjectController')->names('projects')
            ->parameter('projekty', 'project');
        Route::get('publikacie', 'PublicationController@index')->name('publications');
    });
});

Route::get('styleguide', 'StyleGuideController@index')->name('styleguide');

Route::post('settings', function(Request $request) {
    $time = 60 * 1; // in minutes
    if ($request->has('hide_news_ticker')) Cookie::queue('hide_news_ticker', $request->input('hide_news_ticker'), $time);
    if ($request->has('show_map')) Cookie::queue('show_map', $request->input('show_map'), $time);
    return response(null, Response::HTTP_OK);
});

