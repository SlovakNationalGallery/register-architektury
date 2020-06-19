<?php

namespace App\Elasticsearch;

use ScoutElastic\Migratable;
use ScoutElastic\IndexConfigurator as BaseIndexConfigurator;

class IndexConfigurator extends BaseIndexConfigurator
{
    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        'analysis' => [
        	'filter' => [
                'lemmagen_filter' => [
                        'type' => 'lemmagen',
                        'lexicon' => 'sk',
                ],
                'synonyms_filter' => [
                    'type' => 'synonym',
                    'synonyms_path' => 'synonyms/sk_SK.txt',
                ],
                'stopwords_filter' => [
                    'type' => 'stop',
                    'stopwords_path' => 'stop-words/stop-words-slovak.txt',
                ],
                'autocomplete_filter' => [
                    'type' => 'edge_ngram',
                    'min_gram' => 2,
                    'max_gram' => 20,
                ],
            ],
            'analyzer' => [
            	'autocomplete_analyzer' => [
            	    'type' => 'custom',
            	    'tokenizer' => 'standard',
            	    'filter' => [
            	        'lowercase',
            	        'asciifolding',
            	        'autocomplete_filter'
            	    ],
            	],
            	'asciifolding_analyzer' => [
            	    'type' => 'custom',
            	    'tokenizer' => 'standard',
            	    'filter' => [
            	        'lowercase',
            	        'asciifolding',
            	    ],
            	],
            	'default_analyzer' => [
            	    'type' => 'custom',
            	    'tokenizer' => 'standard',
            	    'filter' => [
            	        'lemmagen_filter',
            	        'lowercase',
            	        'stopwords_filter',
            	        'asciifolding',
            	    ],
            	],
            ],
            'normalizer' => [
                'asciifolding_normalizer' => [
                    'type' => 'custom',
                    'filter' => [
                            'lowercase',
                            'asciifolding'
                    ]
                ]
            ]
        ]
    ];
}
