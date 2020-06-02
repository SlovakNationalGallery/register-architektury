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
        $start_dates = $this->buildings()->whereNotNull('project_start_dates')->min('project_start_dates');
        $start_year = $this->parseProjectYear($start_dates);
        
        $end_dates = $this->buildings()->whereNotNull('project_start_dates')->max('project_start_dates');
        $end_year = $this->parseProjectYear($end_dates, $last = true);

        return [$start_year, $end_year];
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
}
