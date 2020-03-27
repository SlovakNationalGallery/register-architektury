<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Architect extends Model
{
    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building');
    }
}
