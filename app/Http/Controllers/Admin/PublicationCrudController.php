<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PublicationRequest;
use App\Models\Publication;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PublicationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PublicationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Publication');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/publications');
        $this->crud->setEntityNameStrings('publication', 'publications');

        $this->crud->setColumns([
            [
                'name' => 'title',
                'type' => 'publication',
            ],
            [
                'name' => 'published',
                'type' => 'published_at',
            ],
            [
                'name' => 'updated_at',
                'type' => 'updated_at',
            ],
        ]);

        $this->crud->addFields([
            'title',
            [
                'name' => 'slug',
                'label' => 'Slug (URL)',
                'type' => 'text',
                'hint' => 'Will be automatically generated from your title, if left empty.'
            ],
            [
                'name' => 'cover_image',
                'type' => 'browse',
            ],
            'authors',
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'summernote',
            ],
            [
                'name' => 'published_at',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'language' => 'sk',
                    'showClear' => true,
                    'stepping' => 30,
                ],
                'wrapper'   => [
                    'class' => 'col-sm-8 col-md-6 form-group',
                ],
            ],
        ]);
    }

    protected function setupListOperation()
    {
        //
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PublicationRequest::class);
        //
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
