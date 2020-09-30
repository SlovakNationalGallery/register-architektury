<?php

namespace App\Models;

use App\Traits\SearchableWithTranslations;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Arr;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        'style',
        'status'
    ];

    protected $appends = ['year_from', 'year_to'];

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
                        'type' => 'keyword',
                        'normalizer' => 'asciifolding_normalizer',
                    ],
                    'stemmed' => [
                        'type' => 'text',
                        'analyzer' => 'default_analyzer',
                    ],
                    'suggest' => [
                        'type' => 'search_as_you_type',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
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
                    'suggest' => [
                        'type' => 'search_as_you_type',
                        'analyzer' => 'asciifolding_analyzer',
                    ]
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
            'year_from' => [
                'type' => 'integer',
            ],
            'year_to' => [
                'type' => 'integer',
            ],

            // Translatable attributes
            'sk.title_sortable' => [
                'type' => 'keyword',
                'normalizer' => 'asciifolding_normalizer',
            ],
            'sk.collections' => [
                'type' => 'keyword',
            ],
            'sk.tags' => [
                'type' => 'keyword',
            ],
            'sk.current_function' => [
                'type' => 'text',
                'analyzer' => 'asciifolding_analyzer',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                ],
            ],

            'en.title_sortable' => [
                'type' => 'keyword',
                'normalizer' => 'asciifolding_normalizer',
            ],
            'en.collections' => [
                'type' => 'keyword',
            ],
            'en.tags' => [
                'type' => 'keyword',
            ],
            'en.current_function' => [
                'type' => 'text',
                'analyzer' => 'asciifolding_analyzer',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                ],
            ],
        ],
    ];

    protected $with = [
        'processedImages',
        'architects',
    ];

    public function architects()
    {
        return $this->belongsToMany('App\Models\Architect');
    }

    public function collections()
    {
        return $this->belongsToMany('App\Models\Collection');
    }

    public function dates()
    {
        return $this->hasMany('App\Models\BuildingDate');
    }

    public function processedImages()
    {
        return $this->hasMany('App\Models\Image')->processed();
    }

    public function getCoverImageAttribute()
    {
        return $this->processedImages->first()->getFirstMedia();
    }

    public function getTagsAttribute($preferredLocale = null)
    {
        $locale = $preferredLocale ?? \App::getLocale();

        $tags = [
            $this->architects->pluck('full_name')->all(),
            $this->location_city,
            $this->getTranslation('current_function', $locale),
            $this->collections->map->getTranslation('title', $locale),
            $this->years_span,
        ];

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

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            Arr::set($array, "$locale.tags", $this->getTagsAttribute($locale));
            Arr::set($array, "$locale.title_sortable", $this->getTranslation('title', $locale));
            Arr::set($array, "$locale.collections", $this->collections->map->getTranslation('title', $locale));
        }

        return $array;
    }

    public static function getFilterValues($payload)
    {
        $locale = \App::getLocale();
        $max_bucket_size = 200;
        $body = (isSet($payload[0]['body'])) ? $payload[0]['body'] : [];

        $body['size'] = 0;
        $body['aggs'] = [
            'architects' => [
                'terms' => [
                    'field' => 'architects',
                    'size' => $max_bucket_size,
                ]
            ],
            'collections' => [
                'terms' => [
                    'field' => "$locale.collections",
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
                    'field' => "$locale.current_function.raw",
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
                    'field' => 'year_to',
                ]
            ],
        ];

        $aggregations = Arr::get(Building::searchRaw($body), 'aggregations');

        return [
            'architects' => collect(Arr::get($aggregations, 'architects.buckets'))
                ->flatMap(fn ($bucket) => [$bucket['key'] => $bucket['doc_count']]),

            'collections' => collect(Arr::get($aggregations, 'collections.buckets'))
                ->flatMap(fn ($bucket) => [$bucket['key'] => $bucket['doc_count']]),

            'locations' => collect(Arr::get($aggregations, 'locations.buckets'))
                ->flatMap(fn ($bucket) => [$bucket['key'] => $bucket['doc_count']]),

            'functions' => collect(Arr::get($aggregations, 'functions.buckets'))
                ->flatMap(fn ($bucket) => [$bucket['key'] => $bucket['doc_count']]),

            'year_min' => Arr::get($aggregations, 'year_min.value'),
            'year_max' => ceil(Arr::get($aggregations, 'year_max.value') / 10) * 10,
        ];
    }
}
