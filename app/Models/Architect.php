<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;
use Illuminate\Support\Str;

class Architect extends Model
{
    use CrudTrait;
    use Searchable;

    protected $indexConfigurator = \App\Elasticsearch\ArchitectsIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    protected $searchableWith = ['buildings'];

    protected $mapping = [
        'properties' => [
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
            // @readme: https://www.elastic.co/blog/numeric-and-date-ranges-in-elasticsearch-just-another-brick-in-the-wall
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

        return $array;
    }
}
