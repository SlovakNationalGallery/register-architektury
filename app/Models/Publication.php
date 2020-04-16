<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Publication extends Model
{
    use CrudTrait, HasSlug;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getIsPublishedAttribute()
    {
        if (!isset($this->published_at)) return false;
        return $this->published_at->isPast();
    }
}
