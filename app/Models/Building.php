<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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

    public function getTagsAttribute()
    {
        $tags = [];
        $tags = $this->makeArray($this->architect_names);
        $tags[] = $this->location_city;
        $tags[] = $this->project_duration_dates;
        return $tags;
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        if ($this->location_lat && $this->location_lon) {
            $array = Arr::except((array) $array, ['location_lat', 'location_lon']);
            $array['location_gps'] = [
                'lat' => $this->location_lat,
                'lon' => $this->location_lon,
            ];
        }

        return $array;
    }

    private function makeArray($str, $delimiter = ',')
    {
        if (is_array($str)) {
            return $str;
        }

        $array = explode($delimiter, $str);
        $array = array_map(function ($value) {
            return trim($value);
        }, $array);

        return array_filter($array, function ($value) {
            return $value !== "";
        });
    }
}
