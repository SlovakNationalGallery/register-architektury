<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeaturedFilterRequest;
use App\Models\Building;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class FeaturedFilterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FeaturedFilterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as storeTrait; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as updateTrait; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\FeaturedFilter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/featured-filters');
        $this->crud->setEntityNameStrings('featured filter', 'featured filters');
    }

    public function store()
    {
        return $this->storeTrait();
    }

    public function update()
    {
        // $request = $this->crud->getRequest();
        // $request->merge([
        //     'function_tags_strings' => collect($request->input('function_tags'))->map(fn ($tag) => (array) json_decode($tag))->toArray(),
        // ]);
        return $this->updateTrait();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(FeaturedFilterRequest::class);

        $select_options = $this->getSelectOptions();

        CRUD::addFields([
            [
                'name' => 'description',
                'type' => 'textarea',
            ],
            [
                'name' => 'architect_tags',
                'type' => 'select2_from_array',
                'label' => 'Architects',
                'options' => $select_options['architect_tags'],
                'allows_null' => false,
                'allows_multiple' => true,
            ],
            [
                'name' => 'location_tags',
                'type' => 'select2_from_array',
                'label' => 'Locations',
                'options' => $select_options['location_tags'],
                'allows_null' => false,
                'allows_multiple' => true,
            ],
            [
                'name' => 'function_tags',
                'type' => 'select2_from_array',
                'label' => 'Functions',
                'options' => $select_options['function_tags'],
                'allows_null' => false,
                'allows_multiple' => true,
            ],
            [
                'name' => 'year_range_tags',
                'type' => 'select2_from_array',
                'label' => 'Decades',
                'options' => $select_options['year_range_tags'],
                'allows_null' => false,
                'allows_multiple' => true,
            ],
            [
                'name' => 'published_at',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'language' => app()->getLocale(),
                    'showClear' => true,
                    'stepping' => 30,
                ],
                'wrapper'   => [
                    'class' => 'col-sm-8 col-md-6 form-group',
                ],
            ],
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    private function getSelectOptions()
    {
        $locale = app()->getLocale();
        $filter_values = Building::getFilterValues([]);

        return [
            'architect_tags' => $filter_values['architects']
                ->mapWithKeys(fn ($index, $value) => [$value => $value]),
            'location_tags' => $filter_values['locations']
                ->mapWithKeys(fn ($index, $value) => [$value => $value]),
            'function_tags' => Building::selectRaw('DISTINCT(current_function)')
                ->whereNotNull("current_function->$locale")
                ->get()->mapWithKeys(fn ($b) => [json_encode($b->getTranslations('current_function')) => $b->current_function]),
            'year_range_tags' => Building::select(DB::raw('DISTINCT(decade)'))
                ->whereNotNull('decade')
                ->orderBy('decade')
                ->get()->map->years_span
                ->mapWithKeys(fn ($value) => [$value => $value]),
        ];
    }
}
