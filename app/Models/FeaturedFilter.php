<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class FeaturedFilter extends Model
{
    use CrudTrait;

    protected $guarded = ['id'];
}
