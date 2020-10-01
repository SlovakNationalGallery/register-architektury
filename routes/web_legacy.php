<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// -- Legacy links
Route::redirect('/sk/uvod/kontakt.html', '/oddelenie-architektury');
Route::redirect('/en/info/kontakt-2.html', '/en/oddelenie-architektury');

Route::redirect('/sk/objekty.html', '/objekty');
Route::redirect('/en/objects.html', '/en/objekty');
Route::get('/sk/objekty/{oldId}-{slug}.html', 'LegacyRedirectController@showBuilding');
Route::get('/en/objects/{oldId}-{slug}.html', 'LegacyRedirectController@showBuilding');

Route::redirect('/sk/architekti.html', '/architekti');
Route::redirect('/en/architects.html', '/en/architekti');
Route::get('/sk/architekti/{oldId}-{slug}.html', 'LegacyRedirectController@showArchitect');
Route::get('/en/architects/{oldId}-{slug}.html', 'LegacyRedirectController@showArchitect');

Route::redirect('/sk/lokality.html', '/objekty');
Route::redirect('/sk/lokality/{anything}', '/objekty');
Route::redirect('/en/locations-2.html', '/en/objekty');
Route::redirect('/en/locations-2/{anything}', '/en/objekty');

Route::redirect('/sk/chronologia.html', '/objekty');
Route::redirect('/sk/chronologia/{anything}', '/objekty');
Route::redirect('/en/chronology-2.html', '/en/objekty');
Route::redirect('/en/chronology-2/{anything}', '/en/objekty');

Route::redirect('/sk/funkcia.html', '/objekty');
Route::redirect('/sk/funkcia/{anything}', '/objekty');
Route::redirect('/en/function-2.html', '/en/objekty');
Route::redirect('/en/function-2/{anything}', '/en/objekty');

Route::redirect('/sk/mapy.html', '/objekty');
Route::redirect('/sk/mapy/{anything}', '/objekty');
Route::redirect('/en/map-google-2.html', '/en/objekty');
Route::redirect('/en/map-google-2/{anything}', '/en/objekty');

Route::redirect('/sk/docomomo.html', '/projekty/docomomo');
Route::redirect('/sk/docomomo/{anything}', '/projekty/docomomo');
Route::redirect('/en/docomomo-2.html', '/en/projekty/docomomo');
Route::redirect('/en/docomomo-2/{anything}', '/en/projekty/docomomo');

Route::redirect('/sk/momowo.html', '/projekty/momowo');
Route::redirect('/sk/momowo/{anything}', '/projekty/momowo');
Route::redirect('/en/momowo.html', '/en/projekty/momowo');
Route::redirect('/en/momowo/{anything}', '/en/projekty/momowo');

Route::redirect('/sk/atrium.html', '/projekty/atrium');
Route::redirect('/sk/atrium/{anything}', '/projekty/atrium');
Route::redirect('/en/atrium-22.html', '/en/projekty/atrium');
Route::redirect('/en/atrium-22/{anything}', '/en/projekty/atrium');

Route::redirect('/sk/sur.html', '/projekty/sur');
Route::redirect('/sk/sur/{anything}', '/projekty/sur');
Route::redirect('/en/sur-3.html', '/en/projekty/sur');
Route::redirect('/en/sur-3/{anything}', '/en/projekty/sur');

Route::redirect('/sk/udalosti.html', '/novinky');
Route::redirect('/en/events.html', '/en/novinky');

Route::redirect('/sk/tipy.html', '/');
Route::redirect('/en/tips.html', '/en');
