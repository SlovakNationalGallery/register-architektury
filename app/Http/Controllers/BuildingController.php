<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $buildings = \App\Models\Building::search(request('search', '*'));
        $locale = \App::getLocale();

        if (request('sort_by') == 'newest') $buildings->orderBy('year_from', 'desc');
        if (request('sort_by') == 'oldest') $buildings->orderBy('year_from', 'asc');
        if (request('sort_by') == 'name_asc') $buildings->orderBy('title.folded', 'asc');
        if (request('sort_by') == 'name_desc') $buildings->orderBy('title.folded', 'desc');

        // default sort if not search
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

        $buildings = $buildings
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
