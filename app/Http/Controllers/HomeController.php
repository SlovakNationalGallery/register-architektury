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

        if (request('sort_by') == 'newest') $buildings->orderBy('year_from', 'desc');
        if (request('sort_by') == 'oldest') $buildings->orderBy('year_from', 'asc');
        if (request('sort_by') == 'name_asc') $buildings->orderBy('title.folded', 'asc');
        if (request('sort_by') == 'name_desc') $buildings->orderBy('title.folded', 'desc');

        $buildings->orderBy('title.folded', 'asc');

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
