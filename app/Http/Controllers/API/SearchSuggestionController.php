<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Building;
use App\Models\Architect;

class SearchSuggestionController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $locale = $request->get('locale', app()->getLocale());

        app()->setLocale($locale);

        return [
            'architects' => $this->architects($search),
            'buildings' => $this->buildings($search, $locale),
        ];
    }

    private function architects($search)
    {
        $architects = Architect::searchRaw([
            'query' => [
                'multi_match' => [
                    'query' => $search,
                    'type' => 'bool_prefix',
                    'fields' => [
                        'first_name.suggest',
                        'last_name.suggest'
                    ]
                ]
            ]
        ]);

        $architects_suggestions = collect(
            Arr::get($architects, 'hits.hits'),
        )
        ->pluck('_source')
        ->toArray();

        $architects = Architect::hydrate($architects_suggestions);
        return $architects->map->only('id', 'url', 'full_name');
    }

    private function buildings($search, $locale)
    {
        $buildings = Building::searchRaw([
            'query' => [
                'multi_match' => [
                    'query' => $search,
                    'type' => 'bool_prefix',
                    'fields' => [
                        $locale.'.title',
                        'title_alternatives'
                    ]
                ]
            ]
        ]);

        $buildings_suggestions = collect(
            Arr::get($buildings, 'hits.hits'),
        )
        ->pluck('_source')
        ->map(fn ($b) => [
            'id' => Arr::get($b, 'id'),
            'architect_names' => Arr::get($b, 'architect_names'),
            'title' => json_encode([
                'sk' => Arr::get($b, 'sk.title'),
                'en' => Arr::get($b, 'en.title'),
            ])
        ])
        ->toArray();

        $buildings = Building::hydrate($buildings_suggestions);
        return $buildings->map->only('id', 'url', 'architect_names', 'title');
    }


}
