<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Publication extends Model
{
    use CrudTrait;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];

    public function getIsPublishedAttribute()
    {
        if (!isset($this->published_at)) return false;
        return $this->published_at->isPast();
    }
}
