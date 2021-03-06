<?php

namespace App\Http\Controllers;

use App\Models\Architect;
use App\Models\Building;
use App\Traits\LoadsBuildingsAndFilterValues;
use Illuminate\Http\Request;

class ArchitectController extends Controller
{
    use LoadsBuildingsAndFilterValues;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $architects = Architect::search('*');

        if ($request->input('first_letter')) {
            $architects = $architects->where('first_letter', $request->input('first_letter'));
        }

        $filter_values = Architect::getFilterValues($architects);

        $first_letters = $filter_values['first_letters'];
        $year_from = max(request('year_from', $filter_values['year_min']), $filter_values['year_min']);
        $year_until = min(request('year_until', $filter_values['year_max']), $filter_values['year_max']);

        if ($year_from > $filter_values['year_min']) {
            $architects->where('active_to', '>=', $year_from);
        }
        if ($year_until < $filter_values['year_max']) {
            $architects->where('active_from', '<=', $year_until);
        }

        if (request('sort_by') == 'newest') $architects->orderBy('active_from', 'desc');
        if (request('sort_by') == 'oldest') $architects->orderBy('active_from', 'asc');
        if (request('sort_by') == 'name_asc') $architects->orderBy('last_name.raw', 'asc');
        if (request('sort_by') == 'name_desc') $architects->orderBy('last_name.raw', 'desc');

        $architects = $architects
            ->orderBy('last_name.raw', 'asc')
            ->with(['buildings', 'media'])
            ->paginate(12);

        return view('architects.index', compact('architects', 'first_letters', 'filter_values'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Architect  $architect
     * @return \Illuminate\Http\Response
     */
    public function show(Architect $architect)
    {
        $building_ids = $architect->buildings()->pluck('id')->toArray();
        $buildings = Building::search('*')->whereIn('id', $building_ids);

        $this->sortBuildings($buildings);

        $buildings = $buildings->paginate(12);

        return view('architects.show', compact('architect', 'buildings'));
    }

}
