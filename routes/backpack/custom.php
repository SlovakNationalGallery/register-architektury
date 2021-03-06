<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('architect', 'ArchitectCrudController');
    Route::crud('building', 'BuildingCrudController');
    Route::crud('image', 'ImageCrudController');
    Route::crud('publications', 'PublicationCrudController');
    Route::crud('articles', 'ArticleCrudController');
    Route::crud('collections', 'CollectionCrudController');
    Route::crud('projects', 'ProjectCrudController');
    Route::crud('featured-filters', 'FeaturedFilterCrudController');
    Route::crud('featured-projects', 'FeaturedProjectCrudController');
}); // this should be the absolute last line of this file
