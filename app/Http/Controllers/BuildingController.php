<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    public function show($id, $slug, Request $request)
    {
    	$building = Building::find($id);

    	if (empty($building)) {
    	    \App::abort(404);
    	}

    	if ($slug != $building->slug) {
    		return redirect($building->url);
    	}

    	return view('building.show', ['building' => $building]);
    }
}
