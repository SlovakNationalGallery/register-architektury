<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Article');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/articles');
        $this->crud->setEntityNameStrings('article', 'articles');

        $this->crud->setColumns([
            [
                'name' => 'title',
                'type' => 'article',
            ],
            [
                'name' => 'published',
                'type' => 'published_at',
            ]
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
            [
                'name' => 'content',
                'type' => 'tinymce',
                'options' => [
                    'entity_encoding' => 'raw',
                    'height' => 480
                ]
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

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ArticleRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
