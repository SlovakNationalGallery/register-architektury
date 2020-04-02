<?php

namespace App\Http\Controllers\Upstream;

use App\Http\Controllers\Controller;
use App\Jobs\Upstream\ResetDatabase as ResetDatabaseJob;
use Illuminate\Http\Request;

class ResetDatabase extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        ResetDatabaseJob::dispatchNow();
    }
}
