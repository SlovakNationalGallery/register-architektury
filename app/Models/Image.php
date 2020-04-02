<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'source_id',
        'building_id',
        'title',
        'author',
        'created_date',
        'source',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/images/'.$this->getKey());
    }

    /* ********************* RELATIONSHIPS ********************** */

    public function building()
    {
        return $this->belongsTo('App\Models\Building');
    }

}
