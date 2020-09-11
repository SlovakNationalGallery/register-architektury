<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\FeaturedFilter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $buildings = Building::search('*');
        $featured_filter = FeaturedFilter::published()->limit(1)->get()->first();

        if ($featured_filter) {
            foreach ($featured_filter->tags as $filter) {
                $buildings->where("$locale.tags", $filter);
            }
        }

	    $buildings = $buildings->paginate(20);
	    return view('home', compact('buildings', 'featured_filter'));
    }
}
