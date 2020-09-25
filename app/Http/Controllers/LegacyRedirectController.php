<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegacyRedirectController extends Controller
{
    public function showBuilding(string $oldId, string $slug)
    {
        $title = (string) Str::of($slug)->replace('-', ' ');
        $building = Building::search('*')->whereMatch('title.folded', $title)->first();

        if ($building) return redirect($building->url);
        return redirect(route('building.index', ['search' => $title]));
    }
}
