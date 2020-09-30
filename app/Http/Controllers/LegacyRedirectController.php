<?php

namespace App\Http\Controllers;

use App\Models\Architect;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class LegacyRedirectController extends Controller
{
    public function showBuilding(string $oldId, string $slug)
    {
        $locale = app()->getLocale();
        $title = (string) Str::of($slug)->replace('-', ' ');
        $building = Building::search('*')->whereMatch("$locale.title_sortable", $title)->first();

        if ($building) return $this->redirectWithoutIndexPhp(route('building.detail', [$building->id, $building->slug], false));
        return $this->redirectWithoutIndexPhp(route('building.index', ['search' => $title], false));
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

        if ($architect) return $this->redirectWithoutIndexPhp(route('architects.show', $architect, false));
        return $this->redirectWithoutIndexPhp(route('architects.index', ['search' => "$lastName $firstNames"], false));
    }

    // Strips /index.php/ off the URL
    private function redirectWithoutIndexPhp($url)
    {
        $rootUrl = Str::replaceLast('/index.php', '', URL::to('/'));
        return redirect("$rootUrl$url");
    }
}
