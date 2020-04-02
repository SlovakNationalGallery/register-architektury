<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Building\BulkDestroyBuilding;
use App\Http\Requests\Admin\Building\DestroyBuilding;
use App\Http\Requests\Admin\Building\IndexBuilding;
use App\Http\Requests\Admin\Building\StoreBuilding;
use App\Http\Requests\Admin\Building\UpdateBuilding;
use App\Models\Building;
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

class BuildingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBuilding $request
     * @return array|Factory|View
     */
    public function index(IndexBuilding $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Building::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            [
                'id', 
                'source_id', 
                'title', 
                'title_alternatives', 
                'processed_date', 
                'architect_names', 
                'builder', 
                'builder_authority', 
                'location_city', 
                'location_district', 
                'location_street', 
                'location_gps', 
                'project_start_dates', 
                'project_duration_dates', 
                'decade', 
                'style', 
                'status', 
                'image_filename'
            ],

            // set columns to searchIn
            ['id', 'title', 'title_alternatives', 'description', 'architect_names', 'builder', 'builder_authority', 'location_city', 'location_district', 'location_street', 'location_gps', 'project_start_dates', 'project_duration_dates', 'style', 'status', 'image_filename', 'bibliography']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.building.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.building.create');

        return view('admin.building.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBuilding $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBuilding $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Building
        $building = Building::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/buildings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/buildings');
    }

    /**
     * Display the specified resource.
     *
     * @param Building $building
     * @throws AuthorizationException
     * @return void
     */
    public function show(Building $building)
    {
        $this->authorize('admin.building.show', $building);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Building $building
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Building $building)
    {
        $this->authorize('admin.building.edit', $building);


        return view('admin.building.edit', [
            'building' => $building,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBuilding $request
     * @param Building $building
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBuilding $request, Building $building)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Building
        $building->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/buildings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/buildings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBuilding $request
     * @param Building $building
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBuilding $request, Building $building)
    {
        $building->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBuilding $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBuilding $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Building::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
