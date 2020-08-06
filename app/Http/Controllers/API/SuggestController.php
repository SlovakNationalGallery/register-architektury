<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;

class SuggestController extends Controller
{

    public function buildings(Request $request)
    {
        $buildings = Building::searchRaw([
            'suggest' => [
                'buildings' => [
                    'prefix' => $request->get('search'),
                    'completion' => [
                        'field' => 'title.suggest'
                    ]
                ]
            ]
        ]);

        $ids = array_column($buildings['suggest']['buildings'][0]['options'], '_id');

        $buildings = Building::findMany($ids);

        $data = [
            'count' => 0,
            'results' => [],
        ];

        foreach ($buildings as $building) {

            $data['count']++;
            $params = [
                'id' => $building->id,
                'url' => $building->url,
                'architects' => $building->architect_names,
                'title' => $building->title,
            ];
            $data['results'][] = array_merge($params);
        }

        return response()->json($data);
    }

}
