<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ScoutElastic\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Architect extends Model implements HasMedia
{
    use CrudTrait;
    use HasSlug;
    use Searchable;
    use InteractsWithMedia;

    protected $indexConfigurator = \App\Elasticsearch\ArchitectsIndexConfigurator::class;

    protected $searchableWith = ['buildings'];

    protected $mapping = [
        'properties' => [
            'first_letter' => [
                'type' => 'keyword',
            ],
            'first_name' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                    'suggest' => [
                        'type' => 'completion',
                        'analyzer' => 'asciifolding_analyzer',
                    ]
                ]
            ],
            'last_name' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                        'normalizer' => 'asciifolding_normalizer',
                    ],
                    'folded' => [
                        'type' => 'text',
                        'analyzer' => 'asciifolding_analyzer',
                    ],
                    'suggest' => [
                        'type' => 'completion',
                        'analyzer' => 'asciifolding_analyzer',
                    ]
                ]
            ],
            'birth_date' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd'
            ],
            'death_date' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd'
            ],
            'bio' => [
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
        ]
    ];

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building');
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->first_name}";
    }

    public static function getFilterValues($search = null)
    {
        $body = $search ? $search->buildPayload()[0]['body'] : self::search('*')->buildPayload()[0]['body'];

        $body['size'] = 0;
        $body['aggs'] = [
            'unfiltered' => [
                'global' => (object) [],
                'aggs' => [
                    'first_letters' => [
                        'terms' => [
                            'field' => 'first_letter',
                            'size' => 26 // A to Z
                        ]
                    ]
                ]
            ],
            'year_min' => [
                'min' => [
                    'field' => 'active_from',
                ]
            ],
            'year_max' => [
                'max' => [
                    'field' => 'active_to',
                ]
            ],
        ];

        $searchResult = self::searchRaw($body);

        return [
            'first_letters' => collect($searchResult['aggregations']['unfiltered']['first_letters']['buckets'])
                ->map(fn ($bucket) => $bucket['key'])
                ->sort(),

            'year_min' => $searchResult['aggregations']['year_min']['value'],
            'year_max' => ceil($searchResult['aggregations']['year_max']['value'] / 10) * 10,
        ];
    }

    public function getHasImageAttribute()
    {
        return $this->hasMedia();
    }

    public function getImageTagAttribute()
    {
        return $this->hasMedia() ? $this->getFirstMedia()->img() : null;
    }

    public function getImageUrlForWidth(int $widthInPixels)
    {
        return  $this->getFirstMedia()->getUrlForWidth($widthInPixels);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlAttribute()
    {
        return route('architects.show', $this);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('full_name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile();
    }

    public function scopeWithUnprocessedImage($query)
    {
        return $query->whereNotNull('image_path')->whereDoesntHave('media');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['first_letter'] = (string) Str::of($this->last_name)->upper()->substr(0, 1)->ascii();
        $array['active_from'] = $this->buildings->min('year_from');
        $array['active_to'] = $this->buildings->max('year_to');

        return $array;
    }
}
