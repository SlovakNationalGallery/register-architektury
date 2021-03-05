<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

// Note that 'images' attribute must be either added to $fillable
// or $guarded must be empty ([]) for this trait to work in mass
// assignment. See https://github.com/laravel/framework/issues/33978
// for details.
trait HasImagesAccessor
{
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
