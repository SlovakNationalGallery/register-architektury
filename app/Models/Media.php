<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{

    public function getUrlForHeight(int $heightInPixels)
    {
        $image = $this->responsiveImages()
            ->files
            ->filter(fn ($file) => $file->height() >= $heightInPixels)
            ->sortBy(fn ($file) => $file->height())
            ->first();

        // Return original if responsive images aren't large enough
        return $image ? $image->url() : $this->getUrl();
    }

    public function getUrlForWidth(int $widthInPixels)
    {
        $image = $this->responsiveImages()
            ->files
            ->filter(fn ($file) => $file->width() >= $widthInPixels)
            ->sortBy(fn ($file) => $file->width())
            ->first();

        // Return original if responsive images aren't large enough
        return $image ? $image->url() : $this->getFirstMediaUrl();
    }
}
