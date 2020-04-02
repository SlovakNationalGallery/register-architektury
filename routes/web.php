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


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('architects')->name('architects/')->group(static function() {
            Route::get('/',                                             'ArchitectsController@index')->name('index');
            Route::get('/create',                                       'ArchitectsController@create')->name('create');
            Route::post('/',                                            'ArchitectsController@store')->name('store');
            Route::get('/{architect}/edit',                             'ArchitectsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ArchitectsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{architect}',                                 'ArchitectsController@update')->name('update');
            Route::delete('/{architect}',                               'ArchitectsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('buildings')->name('buildings/')->group(static function() {
            Route::get('/',                                             'BuildingsController@index')->name('index');
            Route::get('/create',                                       'BuildingsController@create')->name('create');
            Route::post('/',                                            'BuildingsController@store')->name('store');
            Route::get('/{building}/edit',                              'BuildingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BuildingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{building}',                                  'BuildingsController@update')->name('update');
            Route::delete('/{building}',                                'BuildingsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('images')->name('images/')->group(static function() {
            Route::get('/',                                             'ImagesController@index')->name('index');
            Route::get('/create',                                       'ImagesController@create')->name('create');
            Route::post('/',                                            'ImagesController@store')->name('store');
            Route::get('/{image}/edit',                                 'ImagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ImagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{image}',                                     'ImagesController@update')->name('update');
            Route::delete('/{image}',                                   'ImagesController@destroy')->name('destroy');
        });
    });
});