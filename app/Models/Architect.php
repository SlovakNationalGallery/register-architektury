<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Architect extends Model
{
    protected $fillable = [
        'source_id',
        'first_name',
        'last_name',
        'birth_date',
        'birth_place',
        'death_date',
        'death_place',
        'bio'
    ];
}
