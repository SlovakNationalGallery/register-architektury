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
        $search = $request->get('search', '*');
        return [
            'type' => 'FeatureCollection',
            'features' => $this->features($search),
        ];
    }

    private function features($search)
    {
        $buildings = \App\Models\Building::search($search)->take(500)->get();

        $features = [];

        foreach($buildings as $building) {
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

        return $features;
    }


}
