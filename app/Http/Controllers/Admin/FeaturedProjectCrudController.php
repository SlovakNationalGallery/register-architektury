<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeaturedProjectRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FeaturedProjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FeaturedProjectCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Setting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/featured-projects');
        CRUD::setEntityNameStrings('featured project', 'featured projects');
        CRUD::setSubheading('Manage menu items for projects');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(FeaturedProjectRequest::class);
        CRUD::addFields([
            ...$this->buildMenuItemFields('Item #1', 'menu_item_1_title', 'menu_item_1_project_id'),
            ...$this->buildMenuItemFields('Item #2', 'menu_item_2_title', 'menu_item_2_project_id'),
            ...$this->buildMenuItemFields('Item #3', 'menu_item_3_title', 'menu_item_3_project_id'),
            ...$this->buildMenuItemFields('Item #4', 'menu_item_4_title', 'menu_item_4_project_id'),
        ]);
    }

    private function buildMenuItemFields(string $label, string $titleName, string $projectIdName) {
        return [
            [
                'name' => $titleName,
                'label' => $label,
                'type' => 'text',
                'wrapper'   => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'type' => 'select',
                'name' =>  $projectIdName,
                'label' => '&nbsp;',
                'entity' => null,
                'model'=> "App\Models\Project",
                'attribute' => 'title',
                'wrapper'   => [
                    'class' => 'form-group col-md-8'
                ]
            ],
        ];
    }
}
