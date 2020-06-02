<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BuildingFunction extends Model
{
    use CrudTrait;
    use HasTranslations;

    public $translatable = [
        'name',
    ];

    public function buildings()
    {
        return $this->hasMany('App\Models\Building', 'current_function_id');
    }
}
