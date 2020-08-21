<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $collections = Collection::query();

        if (request('sort_by') == 'newest') $collections->orderBy('published_at', 'desc');
        if (request('sort_by') == 'oldest') $collections->orderBy('published_at', 'asc');
        if (request('sort_by') == 'name_asc') $collections->orderByTitle('asc');
        if (request('sort_by') == 'name_desc') $collections->orderByTitle('desc');

        $collections = $collections
            ->with(['buildings'])
            ->paginate(12);

        return view('collections.index', compact('collections'));
    }
}
