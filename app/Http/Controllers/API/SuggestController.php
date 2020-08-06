<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Architect;

class SuggestController extends Controller
{

    public function buildings(Request $request)
    {
        $buildings = Building::searchRaw([
            'suggest' => [
                'buildings_1' => [
                    'prefix' => $request->get('search'),
                    'completion' => [
                        'field' => 'title.suggest'
                    ]
                ],
                'buildings_2' => [
                    'prefix' => $request->get('search'),
                    'completion' => [
                        'field' => 'title_alternatives.suggest'
                    ]
                ]
            ]
        ]);

        $ids_1 = array_column($buildings['suggest']['buildings_1'][0]['options'], '_id');
        $ids_2 = array_column($buildings['suggest']['buildings_2'][0]['options'], '_id');
        $buildings = Building::findMany(array_merge($ids_1, $ids_2));

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

    public function architects(Request $request)
    {
        $architects = Architect::searchRaw([
            'suggest' => [
                'architects_1' => [
                    'prefix' => $request->get('search'),
                    'completion' => [
                        'field' => 'first_name.suggest'
                    ]
                ],
                'architects_2' => [
                    'prefix' => $request->get('search'),
                    'completion' => [
                        'field' => 'last_name.suggest'
                    ]
                ]
            ]
        ]);

        $ids_1 = array_column($architects['suggest']['architects_1'][0]['options'], '_id');
        $ids_2 = array_column($architects['suggest']['architects_2'][0]['options'], '_id');
        $architects = Architect::findMany(array_merge($ids_1, $ids_2));

        $data = [
            'count' => 0,
            'results' => [],
        ];

        foreach ($architects as $architect) {

            $data['count']++;
            $params = [
                'id' => $architect->id,
                'url' => $architect->url,
                'name' => $architect->full_name,
            ];
            $data['results'][] = array_merge($params);
        }

        return response()->json($data);
    }

}
