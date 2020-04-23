<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class RegarchIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        // 'analysis' => [
        //     'analyzer' => [
        //     ]    
        // ]
    ];
}