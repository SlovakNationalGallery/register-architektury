<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'source_id',
        'title',
        'title_alternatives',
        'description',
        'processed_date',
        'architect_names',
        'builder',
        'builder_authority',
        'location_city',
        'location_district',
        'location_street',
        'location_gps',
        'project_start_dates',
        'project_duration_dates',
        'decade',
        'style',
        'status',
        'image_filename',
        'bibliography',
    
    ];
    
    
    protected $dates = [
        'processed_date',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/buildings/'.$this->getKey());
    }

    /* ********************* RELATIONSHIPS ********************** */

    public function architects()
    {
        return $this->belongsToMany('App\Models\Architect');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

}
