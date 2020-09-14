<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Traits\LoadsBuildingsAndFilterValues;

class BuildingController extends Controller
{
    use LoadsBuildingsAndFilterValues;

    public function index(Request $request)
    {
        $data = $this->loadBuildingsAndFilterValues($request);
        $filter_values = $data->filter_values;

        $buildings = $data->buildings
            ->with(['dates', 'collections', 'architects'])
            ->paginate(20);

        return view('building.index', compact(
            'buildings',
            'filter_values',
        ));
    }

    public function show($id, $slug, Request $request)
    {
    	$building = Building::findOrFail($id);
        $locale = \App::getLocale();

    	if ($slug != $building->slug) {
    		return redirect($building->url);
    	}

        $related_buildings = Building::search($building->id)
            ->rule(function($builder) use ($locale) {
                return [
                    'must' => [
                        'more_like_this' => [
                            'fields' => [$locale . '.tags'],
                            'like' => [
                                '_id' => $builder->query
                            ],
                            'min_term_freq' => 1,
                            'min_doc_freq' => 1,
                            'minimum_should_match' => '35%'
                        ]
                    ]
                ];
            })
            ->with(['dates', 'collections', 'architects'])
            ->paginate(8);

    	return view('building.show', [
            'building' => $building,
            'related_buildings' => $related_buildings,
        ]);
    }

}
