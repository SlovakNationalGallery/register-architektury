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
    public function index()
    {
        return view('architects.index');
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
