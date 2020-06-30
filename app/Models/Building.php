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

    public function dates()
    {
        return $this->hasMany('App\Models\BuildingDate');
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
        $tags[] = $this->current_function;
        $tags[] = $this->years_span;
        return Arr::flatten(Arr::where($tags, fn ($tag) => !empty($tag)));
    }

    public function getUrlAttribute()
    {
        return route('building.detail', [$this->id, $this->slug]);
    }

    public function getSlugAttribute()
    {
        return str_slug($this->title);
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

    public static function getFilterValues($payload)
    {
        $max_bucket_size = 200;
        $body = (isSet($payload[0]['body'])) ? $payload[0]['body'] : [];

        $body['aggs'] = [
            'architects' => [
                'terms' => [
                    'field' => 'architects',
                    'size' => $max_bucket_size,
                ]
            ],
            'locations' => [
                'terms' => [
                    'field' => 'location_city.raw',
                    'size' => $max_bucket_size,
                ]
            ],
            'functions' => [
                'terms' => [
                    'field' => 'current_function.raw',
                    'size' => $max_bucket_size,
                ]
            ],
            'year_min' => [
                'min' => [
                    'field' => 'year_from',
                ]
            ],
            'year_max' => [
                'max' => [
                    'field' => 'year_from',
                ]
            ],
        ];

        $searchResult = Building::searchRaw($body);

        $values = collect();
        foreach ($searchResult['aggregations'] as $attribute => $results) {
            if (isSet($results['value'])) {
                $values[$attribute] = $results['value'];
            } else {
                $values[$attribute] = collect($results['buckets'])
                ->mapWithKeys(function ($bucket) {
                    return [$bucket['key'] => $bucket['doc_count']];
                });
            }
        }
        return $values;
    }

}
