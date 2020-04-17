<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Publishable;

class Collection extends Model
{
    use CrudTrait, HasSlug, Publishable;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building')->withPivot('position');
    }
}
