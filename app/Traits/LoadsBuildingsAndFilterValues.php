<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Building;

trait LoadsBuildingsAndFilterValues
{
    protected function loadBuildingsAndFilterValues(Request $request)
    {
        $buildings = Building::search(request('search', '*'));
        $locale = \App::getLocale();

        $buildings = $this->applySort($buildings);

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

        return (object)[
            'buildings' => $buildings,
            'filter_values' => $filter_values
        ];
    }

    protected function applySort($buildings)
    {

        if (request('sort_by') == 'newest') $buildings->orderBy('year_from', 'desc');
        if (request('sort_by') == 'oldest') $buildings->orderBy('year_from', 'asc');
        if (request('sort_by') == 'name_asc') $buildings->orderBy('title.folded', 'asc');
        if (request('sort_by') == 'name_desc') $buildings->orderBy('title.folded', 'desc');

        // default sort if not search
        if (!request()->filled('search') && !request()->filled('sort_by')) {
            $buildings->orderBy('title.folded', 'asc');
        }

        return $buildings;
    }
}
