<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Building;
use App\Traits\LoadsBuildingsAndFilterValues;

class MarkersController extends Controller
{
    use LoadsBuildingsAndFilterValues;

    public function index(Request $request)
    {
        $data = $this->loadBuildingsAndFilterValues($request);

        $buildings = $data->buildings->take(1000)->get();

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
