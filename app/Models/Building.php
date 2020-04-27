<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class Building extends Model
{
    use CrudTrait;
    use Searchable;

    protected $indexConfigurator = \App\Elasticsearch\BuildingsIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                    'stemmed' => [
                        'type' => 'text',
                        'analyzer' => 'default_analyzer',
                    ],
                    // 'suggest' => [
                    //     'type' => 'text',
                    //     'analyzer' => 'autocomplete_analyzer',
                    //     'search_analyzer' => 'asciifolding_analyzer',
                    // ]
                ]
            ],
            'title_alternatives' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                    'stemmed' => [
                        'type' => 'text',
                        'analyzer' => 'default_analyzer',
                    ],
                    // 'suggest' => [
                    //     'type' => 'text',
                    //     'analyzer' => 'autocomplete_analyzer',
                    //     'search_analyzer' => 'asciifolding_analyzer',
                    // ]
                ]
            ],
            'description' => [
                'type' => 'text',
                'fields' => [
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                    'stemmed' => [
                        'type' => 'text',
                        'analyzer' => 'default_analyzer',
                    ],
                ]
            ],
            'architect_names' => [
                'type' => 'text',
                'fields' => [
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                ]
            ],
            'location_city' => [
                'type' => 'text',
                'fields' => [
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                ]
            ],
            'location_city' => [
                'type' => 'text',
                'fields' => [
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                ]
            ],
            'location_gps' => [
                'type' => 'geo_point',
            ],
        ]
    ];

    public function architects()
    {
        return $this->belongsToMany('App\Models\Architect');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function getLocationGpsAttribute($value)
    {
    	// convert Degree, Minutes, Seconds (DMS) to decimal if necessary
    	if (strpos($value, '°') !== false) {
    		$parts = preg_split("/[^\d\w.]+/", trim($value));
    		$lat = $this->DMStoDD($parts[0], $parts[1], $parts[2], $parts[3]);
		    $lng = $this->DMStoDD($parts[4], $parts[5], $parts[6], $parts[7]);
		    return "$lat,$lng";
    	}
    }

    private function DMStoDD($degrees, $minutes, $seconds, $direction)
    {
        $dd = $degrees + $minutes/60 + $seconds/(60*60);

        if ($direction == "S" || $direction == "W") {
            $dd = $dd * -1;
        } 
        return $dd;
    }    
}
