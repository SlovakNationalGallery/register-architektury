<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function building()
    {
        return $this->belongsTo('App\Models\Building');
    }
}
