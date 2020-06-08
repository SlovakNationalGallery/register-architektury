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

    public function getActiveYearsAttribute()
    {
        $project_dates = $this->buildings()->whereNotNull('project_start_dates')->select('project_start_dates')->get();
        $start_dates = $project_dates->min('project_start_dates');
        $start_year = $this->parseProjectYear($start_dates);

        $end_dates = $project_dates->max('project_start_dates');
        $end_year = $this->parseProjectYear($end_dates, $last = true);

        return (!empty($start_year) && !empty($end_year)) ? [$start_year, $end_year] : null;
    }

    private function parseProjectYear($dates, $last = false)
    {
        $dates = explode(';', $dates);
        $date = reset($dates);

        $date = Str::of($date)->after(':');
        if ($last) {
            return (string)$date->after('-')->trim();
        }
        return (string)$date->before('-')->trim();

    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $active_years = $this->active_years;
        if (!empty($active_years)) {
            $active_years = asort($active_years); // @todo: remove after fix min/max date
            $array['active_years'] = [
                'lte' => $active_years[0],
                'gte' => $active_years[1],
            ];
        }

        return $array;
    }
}
