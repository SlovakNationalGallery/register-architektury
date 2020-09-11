<?php

namespace App\Models;

use App\Traits\Publishable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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

    public function getTagsAttribute()
    {
        return collect([
            ...$this->architect_tags,
            ...$this->getLocalizedFunctionTags(app()->getLocale()),
            ...$this->location_tags,
            ...$this->year_range_tags,
        ]);
    }

    public function getLocalizedFunctionTags($locale)
    {
        $fallbackLocale = config('translatable.fallback_locale');
        return collect($this->function_tags)
            ->map(fn ($serialized_tag) => (array) json_decode($serialized_tag))
            ->map(fn ($tag) => Arr::get($tag, $locale) ?? Arr::get($tag, $fallbackLocale));
    }
}
