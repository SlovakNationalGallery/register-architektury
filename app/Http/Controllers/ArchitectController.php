<?php

namespace App\Http\Controllers;

use App\Models\Architect;

class ArchitectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $first_letters = Architect::searchFirstLetters();
        $architects = Architect::search('*')
            ->orderBy('last_name.raw', 'asc')
            ->paginate(12);

        return view('architects.index', compact('architects', 'first_letters'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Architect  $architect
     * @return \Illuminate\Http\Response
     */
    public function show(Architect $architect)
    {
        //
    }
}
