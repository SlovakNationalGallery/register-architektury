<?php

namespace App\Models;

use App\Scopes\PublishedScope;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Publishable;
use Illuminate\Support\Facades\App;

class Collection extends Model
{
    use CrudTrait, HasSlug, Publishable, HasTranslations;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];
    protected $translatable = ['title', 'description'];

    protected static function booted()
    {
        static::addGlobalScope(new PublishedScope);
    }

    public function clearGlobalScopes()
    {
        static::$globalScopes = [];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building')->withPivot('position')->orderBy('position');
    }

    public function scopeOrderByTitle($query, $direction = 'ASC')
    {
        $locale = App::getLocale();
        $fallbackLocale = config('translatable.fallback_locale');

        return $query->orderByRaw("COALESCE(title->\"$.$locale\", title->\"$.$fallbackLocale\") $direction");
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
