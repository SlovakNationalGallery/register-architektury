<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $search = request()->filled('search') ? request()->input('search') : '*';
        $buildings = \App\Models\Building::search($search);

        if (request()->input('sort_by') == 'newest') $buildings->orderBy('year_from', 'desc');
        if (request()->input('sort_by') == 'oldest') $buildings->orderBy('year_from', 'asc');

        foreach (request()->input('filters', []) as $filter) {
            $buildings->where('tags', $filter);
        }

        $filter_values = \App\Models\Building::getFilterValues($buildings->buildPayload());
        $buildings = $buildings->paginate(20);

        return view('building.index', compact('buildings','filter_values'));
    }

    public function show($id, $slug, Request $request)
    {
    	$building = Building::find($id);

    	if (empty($building)) {
    	    \App::abort(404);
    	}

    	if ($slug != $building->slug) {
    		return redirect($building->url);
    	}

        $related_buildings = Building::search($building->id)
            ->rule(function($builder) {
                return [
                    'must' => [
                        'more_like_this' => [
                            'fields' => ['tags'],
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
            ->paginate(8);

    	return view('building.show', [
            'building' => $building,
            'related_buildings' => $related_buildings,
        ]);
    }
}
