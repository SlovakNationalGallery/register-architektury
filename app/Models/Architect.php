<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ScoutElastic\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Architect extends Model implements HasMedia
{
    use CrudTrait;
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
            'active_years' => [
                'type' => 'integer_range',
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

    public static function searchFirstLetters()
    {
        $searchResult = self::searchRaw([
            'size' => 0, // Return counts only
            'aggs' => [
                'first_letters' => [
                    'terms' => [
                        'field' => 'first_letter',
                        'size' => 26 // A to Z
                    ]
                ]
            ]
        ]);

        return collect($searchResult['aggregations']['first_letters']['buckets'])
            ->map(fn ($bucket) => $bucket['key'])
            ->sort();
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building');
    }

    public function getActiveFromAttribute()
    {
        return $this->buildings->min('year_from');
    }

    public function getActiveToAttribute()
    {
        return $this->buildings->max('year_to');
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->first_name}";
    }

    public function getFirstLetterAttribute()
    {
        return (string) Str::of($this->last_name)->upper()->substr(0, 1)->ascii();
    }

    public function getHasImageAttribute()
    {
        return $this->hasMedia();
    }

    public function getImageTagAttribute()
    {
        return $this->hasMedia() ? $this->getFirstMedia()->img() : null;
    }

    public function getImageUrl(int $widthInPixels)
    {
        $widthInPixels *= 2; // Increase for retina displays

        $image = $this->getFirstMedia()
            ->responsiveImages()
            ->files
            ->filter(fn ($file) => $file->width() >= $widthInPixels)
            ->sortBy(fn ($file) => $file->width())
            ->first();

        // Return original if responsive images aren't large enough
        return $image ? $image->url() : $this->getFirstMediaUrl();
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

        $array['active_years'] = [
            'gte' => $this->active_from,
            'lte' => $this->active_to,
        ];

        $array['first_letter'] = $this->first_letter;

        return $array;
    }
}
