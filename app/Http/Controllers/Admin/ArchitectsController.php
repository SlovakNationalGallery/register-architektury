<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Architect\BulkDestroyArchitect;
use App\Http\Requests\Admin\Architect\DestroyArchitect;
use App\Http\Requests\Admin\Architect\IndexArchitect;
use App\Http\Requests\Admin\Architect\StoreArchitect;
use App\Http\Requests\Admin\Architect\UpdateArchitect;
use App\Models\Architect;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ArchitectsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexArchitect $request
     * @return array|Factory|View
     */
    public function index(IndexArchitect $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Architect::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'source_id', 'first_name', 'last_name', 'birth_date', 'birth_place', 'death_date', 'death_place'],

            // set columns to searchIn
            ['id', 'first_name', 'last_name', 'birth_place', 'death_place', 'bio']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.architect.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.architect.create');

        return view('admin.architect.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArchitect $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreArchitect $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Architect
        $architect = Architect::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/architects'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/architects');
    }

    /**
     * Display the specified resource.
     *
     * @param Architect $architect
     * @throws AuthorizationException
     * @return void
     */
    public function show(Architect $architect)
    {
        $this->authorize('admin.architect.show', $architect);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Architect $architect
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Architect $architect)
    {
        $this->authorize('admin.architect.edit', $architect);


        return view('admin.architect.edit', [
            'architect' => $architect,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArchitect $request
     * @param Architect $architect
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateArchitect $request, Architect $architect)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Architect
        $architect->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/architects'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/architects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyArchitect $request
     * @param Architect $architect
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyArchitect $request, Architect $architect)
    {
        $architect->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyArchitect $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyArchitect $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Architect::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
