<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Image\BulkDestroyImage;
use App\Http\Requests\Admin\Image\DestroyImage;
use App\Http\Requests\Admin\Image\IndexImage;
use App\Http\Requests\Admin\Image\StoreImage;
use App\Http\Requests\Admin\Image\UpdateImage;
use App\Models\Image;
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

class ImagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexImage $request
     * @return array|Factory|View
     */
    public function index(IndexImage $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Image::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'source_id', 'building_id', 'title', 'author', 'created_date', 'source'],

            // set columns to searchIn
            ['id', 'title', 'author', 'created_date', 'source']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.image.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.image.create');

        return view('admin.image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreImage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreImage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Image
        $image = Image::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/images'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/images');
    }

    /**
     * Display the specified resource.
     *
     * @param Image $image
     * @throws AuthorizationException
     * @return void
     */
    public function show(Image $image)
    {
        $this->authorize('admin.image.show', $image);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Image $image
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Image $image)
    {
        $this->authorize('admin.image.edit', $image);


        return view('admin.image.edit', [
            'image' => $image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateImage $request
     * @param Image $image
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateImage $request, Image $image)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Image
        $image->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/images'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/images');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyImage $request
     * @param Image $image
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyImage $request, Image $image)
    {
        $image->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyImage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyImage $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Image::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
