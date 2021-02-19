<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $publications = Publication::published();

        if (request('sort_by') == 'newest') $publications->orderBy('published_at', 'desc');
        if (request('sort_by') == 'oldest') $publications->orderBy('published_at', 'asc');
        if (request('sort_by') == 'name_asc') $publications->orderByTitle('asc');
        if (request('sort_by') == 'name_desc') $publications->orderByTitle('desc');

        $publications = $publications
            ->orderBy('published_at', 'desc') // sort newest-first by default
            ->get();

        return view('publications.index', compact('publications'));
    }
}
