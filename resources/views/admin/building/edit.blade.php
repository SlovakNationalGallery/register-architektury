@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.building.actions.edit', ['name' => $building->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <building-form
                :action="'{{ $building->resource_url }}'"
                :data="{{ $building->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.building.actions.edit', ['name' => $building->title]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.building.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </building-form>

        </div>
    
</div>

@endsection