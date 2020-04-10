<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use CrudTrait;

    public function architects()
    {
        return $this->belongsToMany('App\Models\Architect');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}
