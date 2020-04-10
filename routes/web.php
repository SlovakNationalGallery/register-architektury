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
    //TODO move fzaninotto/faker to require-dev in composer.json once we have data
    $faker = Faker\Factory::create(config('app.faker_locale'));
    $faker->addProvider(new Faker\Provider\Lorem($faker));
    return view('welcome', compact('faker'));
});
