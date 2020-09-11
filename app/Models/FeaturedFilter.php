<?php

namespace App\Models;

use App\Traits\Publishable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class FeaturedFilter extends Model
{
    use CrudTrait, HasTranslations, Publishable;

    protected $guarded = ['id'];
    protected $translatable = ['description'];
    protected $casts = [
        'architect_tags' => 'array',
        'function_tags' => 'array',
        'location_tags' => 'array',
        'year_range_tags' => 'array',
    ];
}
