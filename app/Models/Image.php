<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use CrudTrait;

    public function building()
    {
        return $this->belongsTo('App\Models\Building');
    }
}
