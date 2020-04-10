<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Architect extends Model
{
    use CrudTrait;

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building');
    }
}
