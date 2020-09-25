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

Route::prefix('index.php')->group(function ()
{
    Route::group(['prefix' => 'sk'], function()
    {
        Route::redirect('/', '/');
        Route::redirect('uvod/kontakt.html', '/oddelenie-architektury');
        Route::redirect('objekty.html', '/objekty');
        Route::redirect('lokality.html', '/objekty');
        Route::redirect('architekti.html', '/architekti');
        Route::redirect('chronologia.html', '/objekty');
        Route::redirect('funkcia.html', '/objekty');
        Route::redirect('mapy.html', '/objekty');
        Route::redirect('docomomo.html', '/projekty/docomomo');
        Route::redirect('atrium.html', '/projekty/atrium');
        Route::redirect('momowo.html', '/projekty/momowo');
        Route::redirect('sur.html', '/projekty/sur');
        Route::redirect('udalosti.html', '/novinky');
        Route::redirect('tipy.html', '/');

        Route::get('objekty/{oldId}-{slug}.html', 'LegacyRedirectController@showBuilding');

        Route::fallback(fn () => redirect('/'));
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
