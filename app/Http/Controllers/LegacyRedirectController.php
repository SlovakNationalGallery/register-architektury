<?php

namespace App\Http\Controllers;

use App\Models\Architect;
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

    public function showArchitect(string $oldId, string $slug)
    {
        $allNames = Str::of($slug)->explode('-');
        $lastName = $allNames->shift();
        $firstNames = $allNames->join(' ');

        $architect = Architect::search('*')
            ->whereMatch('first_name.folded', $firstNames)
            ->whereMatch('last_name.folded', $lastName)
            ->first();

        if ($architect) return redirect(route('architects.show', $architect));
        return redirect(route('architects.index', ['search' => "$lastName $firstNames"]));
    }
}
