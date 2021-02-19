<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait HasImagesAccessor
{
    public function initializeHasImagesAccessor()
    {
        $this->fillable[] = 'images';
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
}
