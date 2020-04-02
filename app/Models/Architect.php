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
        'bio',
    
    ];
    
    
    protected $dates = [
        'birth_date',
        'death_date',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/architects/'.$this->getKey());
    }

    /* ********************* RELATIONSHIPS ********************** */

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building');
    }

}
