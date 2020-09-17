<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\FeaturedFilter;
use Illuminate\Http\Request;
use App\Traits\LoadsBuildingsAndFilterValues;

class HomeController extends Controller
{
    use LoadsBuildingsAndFilterValues;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $buildings = Building::search('*');

        $buildings = $this->applySort($buildings);

        $featured_filter = FeaturedFilter::published()->orderBy('published_at', 'desc')->first();

        if ($featured_filter) {
            foreach ($featured_filter->tags as $filter) {
                $buildings->where("$locale.tags", $filter);
            }
        }

	    $buildings = $buildings->with(['dates', 'collections', 'architects'])->paginate(20);
	    return view('home', compact('buildings', 'featured_filter'));
    }
}
