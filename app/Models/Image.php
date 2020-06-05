<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Image extends Model implements HasMedia
{
    use CrudTrait;
    use InteractsWithMedia;

    public function building()
    {
        return $this->belongsTo('App\Models\Building');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(300);
    }
}
