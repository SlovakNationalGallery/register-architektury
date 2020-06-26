<?php

namespace App\Http\Controllers;

use App\Models\Architect;
use Illuminate\Http\Request;

class ArchitectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $first_letters = Architect::searchFirstLetters();
        $architects = Architect::search('*');

        if ($request->input('first_letter')) {
            $architects = $architects->where('first_letter', $request->input('first_letter'));
        }

        $architects = $architects
            ->orderBy('last_name.raw', 'asc')
            ->with(['buildings', 'media'])
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
