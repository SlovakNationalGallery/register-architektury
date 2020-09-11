<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Building;

class MarkersController extends Controller
{

    public function index(Request $request)
    {
        $buildings = \App\Models\Building::search(request('search', '*'));
        $locale = \App::getLocale();

        if (!request()->filled('search') && !request()->filled('sort_by')) {
            $buildings->orderBy('title.folded', 'asc');
        }

        foreach (request()->input('filters', []) as $filter) {
            $buildings->where("$locale.tags", $filter);
        }

        $filter_values = Building::getFilterValues($buildings->buildPayload());

        $year_from = max(request('year_from', $filter_values['year_min']), $filter_values['year_min']);
        $year_until = min(request('year_until', $filter_values['year_max']), $filter_values['year_max']);

        if ($year_from > $filter_values['year_min']) {
            $buildings->where('year_from', '>=', $year_from);
        }
        if ($year_until < $filter_values['year_max']) {
            $buildings->where('year_to', '<=', $year_until);
        }

        $buildings = $buildings->take(500)->get();

        return [
            'type' => 'FeatureCollection',
            'features' => $this->features($buildings),
        ];
    }

    private function features($buildings)
    {
        $features = [];

        foreach($buildings as $building) {
            if (!empty($building->lng_lat)) {
                $features[] = [
                        'type' => 'Feature',
                        'geometry' => [
                            'type' => 'Point',
                            'coordinates' => $building->lng_lat
                        ],
                        'properties' => [
                            'id' => $building->id,
                            'title' => $building->title,
                            'description' => $building->architect_names,
                            'url' => $building->url
                        ]
                ];
            }
        }

        return $features;
    }


}
