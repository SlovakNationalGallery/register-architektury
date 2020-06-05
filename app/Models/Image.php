<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Image extends Model implements HasMedia
{
    use CrudTrait;
    use InteractsWithMedia;

    public function building()
    {
        return $this->belongsTo('App\Models\Building');
    }
}
