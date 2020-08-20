<?php

namespace App\Models;

use App\Traits\Publishable;
use App\Traits\HasNavigationHeadings;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model implements HasMedia
{
    use CrudTrait, InteractsWithMedia, HasSlug, HasTranslations, Publishable, HasNavigationHeadings;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];
    protected $translatable = ['title', 'content'];

    public function getCoverImageTagAttribute()
    {
        return $this->getFirstMedia()->img();
    }

    public function getImagesAttribute()
    {
        return $this->getMedia();
    }

    public function setImagesAttribute($uploaded_files)
    {
        collect($uploaded_files)
            ->filter() // Ignore nulls
            ->each(fn (UploadedFile $file) => $this
                ->addMedia($file)
                ->toMediaCollection()
            );
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->withResponsiveImages();
    }
}
