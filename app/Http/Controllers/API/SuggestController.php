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

        return \App\Http\Resources\Building::collection($buildings);
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

        return \App\Http\Resources\Architect::collection($architects);
    }

}
