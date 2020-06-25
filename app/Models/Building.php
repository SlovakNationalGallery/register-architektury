<?php

namespace App\Models;

use App\Traits\SearchableWithTranslations;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Arr;

class Building extends Model
{
    use CrudTrait;
    use Searchable;
    use HasTranslations;
    use SearchableWithTranslations;

    public $translatable = [
        'title',
        'description',
        'current_function',
    ];

    public static $filterable = [
        'architects' => 'architects',
        'locations' => 'location_city.raw',
        'functions' => 'current_function.raw',
    ];


    protected $appends = ['tags', 'year_from'];

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
                    'raw' => [
                        'type' => 'keyword',
                    ],
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                ]
            ],
            'location_city' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                ]
            ],
            'location_gps' => [
                'type' => 'geo_point',
            ],
            'architects' => [
                'type' => 'keyword',
            ],
            'tags' => [
                'type' => 'keyword',
            ],
            'year_from' => [
                'type' => 'integer',
            ],
            'current_function' => [
                'type' => 'text',
                'analyzer' => 'asciifolding_analyzer',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                ],
            ],
        ]
    ];

    protected $with = [
        'processedImages',
        'architects',
    ];

    public function architects()
    {
        return $this->belongsToMany('App\Models\Architect');
    }

    public function processedImages()
    {
        return $this->hasMany('App\Models\Image')->processed();
    }

    public function getCoverImageTagAttribute()
    {
        return $this->processedImages->first()->getFirstMedia()->img();
    }

    public function getTagsAttribute()
    {
        $tags = $this->architects->pluck('full_name')->all();
        $tags[] = $this->location_city;
        if (!empty($this->current_function)) {
           $tags[] = $this->current_function;
        }
        $tags[] = $this->years_span;
        return $tags;
    }

    public function getUrlAttribute()
    {
        return route('building.detail', [$this->id, $this->slug]);
    }

    public function getSlugAttribute()
    {
        return str_slug($this->title);
    }

    public function getProjectDurationDatesArrayAttribute()
    {
        return $this->makeArray($this->project_duration_dates, ';');
    }

    public function getProjectStartDatesArrayAttribute()
    {
        return $this->makeArray($this->project_start_dates, ';');
    }

    public function getYearFromAttribute()
    {
        return $this->decade;
    }

    public function getYearToAttribute()
    {
        return $this->decade + 9;
    }

    public function getYearsSpanAttribute()
    {
        return $this->year_from . ' - ' . $this->year_to;

    }

    public function getLngLatAttribute()
    {
        if (empty($this->location_gps)) {
            return null;
        }

        $gps = explode(',', $this->location_gps);
        return array_reverse($gps);
    }

    public function toSearchableArray()
    {
        $array = Arr::except($this->toSearchableArrayWithTranslations(), [
            'processed_images',
            'architects',
        ]);
        $array['architects'] = $this->architects->pluck('full_name')->all();

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

    public static function listValues($attribute, $search_query = [])
    {
        if (!isSet(self::$filterable[$attribute])) return false;
        $max_bucket_size = 100;

        $searchResult = Building::searchRaw([
            'aggs' => [
                $attribute => [
                    'terms' => [
                        'field' => self::$filterable[$attribute],
                        'size' => $max_bucket_size,
                    ]
                ]
            ]
        ]);

        return collect($searchResult['aggregations'][$attribute]['buckets'])
            ->mapWithKeys(function ($bucket) {
                return [$bucket['key'] => $bucket['doc_count']];
            });
    }
}
