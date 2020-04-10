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
                'name' => 'cover_image',
                'type' => 'image',
                'height' => '40px',
                'width' => '40px',

            ],
            'title',
            [
                'name' => 'Published',
                'type' => 'published_at',
            ],
            [
                'name' => 'updated_at',
                'type' => 'updated_at',
            ],
        ]);

        $this->crud->addFields([
            'title',
            'slug',
            'authors',
            'cover_image',
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'summernote',
            ],
            [
                'name' => 'published_at',
                'type' => 'datetime',
                'allows_null' => true,
                'wrapper'   => [
                    'class' => 'col-sm-8 col-md-6',
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
