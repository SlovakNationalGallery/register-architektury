<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CollectionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Collection;

/**
 * Class CollectionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CollectionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Collection');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/collections');
        $this->crud->setEntityNameStrings('collection', 'collections');
        $this->crud->query = $this->crud->query->withoutGlobalScopes();
        $this->crud->model->clearGlobalScopes();

        $this->crud->setColumns([
            [
                'name' => 'title',
                'type' => 'collection',
            ],
            [
                'name' => 'buildings',
                'type' => 'relationship_count',
                'suffix' => '',
            ],
            [
                'name' => 'published',
                'type' => 'published_at',
            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'type' => 'relationship',
                'name'  => 'project_id',
            ],
            [
                'name' => 'slug',
                'label' => 'Slug (URL)',
                'type' => 'text',
                'hint' => 'Will be automatically generated from your title, if left empty.'
            ],
            [
                'name' => 'description',
                'type' => 'tinymce',
                'options' => [
                    'entity_encoding' => 'raw',
                    'height' => 480,
                    'plugins' => 'image,link,media,anchor,fullscreen',
                    'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | fullscreen'
                ]
            ],
            [
                'name' => 'buildings',
                'type' => 'items_sortable',
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
        $this->crud->setValidation(CollectionRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function update()
    {
        $removedBuildings = $this->getRemovedBuildings();

        $response = $this->traitUpdate();
        $this->syncBuildingPositions();
        $this->reindexBuildings($removedBuildings);
        return $response;
    }

    public function store()
    {
        $response = $this->traitStore();
        $this->syncBuildingPositions();
        $this->reindexBuildings();
        return $response;
    }

    private function reindexBuildings(Collection $removedBuildings = null) {
        // Re-index removed buildings
        if ($removedBuildings) $removedBuildings->searchable();

        // Re-index added buildings
        $this->crud->getCurrentEntry()->buildings()->searchable();
    }

    private function getRemovedBuildings() {
        $newBuildingIds = $this->crud->getRequest()->get('buildings', []);
        return $this->crud->getCurrentEntry()->buildings()->whereNotIn('id', $newBuildingIds)->get();
    }

    private function syncBuildingPositions() {
        $buildings = [];
        $building_ids = $this->crud->getRequest()->get('buildings', []);
        foreach ($building_ids as $building_position => $building_id) {
            $buildings[$building_id] = ['position' => $building_position];
        }
        $this->crud->getCurrentEntry()->buildings()->sync($buildings);
    }
}
