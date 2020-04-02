@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.building.actions.index'))

@section('body')

    <building-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/buildings') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.building.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/buildings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.building.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.building.columns.id') }}</th>
                                        <th is='sortable' :column="'source_id'">{{ trans('admin.building.columns.source_id') }}</th>
                                        <th is='sortable' :column="'title'">{{ trans('admin.building.columns.title') }}</th>
                                        {{-- <th is='sortable' :column="'title_alternatives'">{{ trans('admin.building.columns.title_alternatives') }}</th> --}}
                                        {{-- <th is='sortable' :column="'processed_date'">{{ trans('admin.building.columns.processed_date') }}</th> --}}
                                        <th is='sortable' :column="'architect_names'">{{ trans('admin.building.columns.architect_names') }}</th>
                                        <th is='sortable' :column="'builder'">{{ trans('admin.building.columns.builder') }}</th>
                                        {{-- <th is='sortable' :column="'builder_authority'">{{ trans('admin.building.columns.builder_authority') }}</th> --}}
                                        <th is='sortable' :column="'location_city'">{{ trans('admin.building.columns.location_city') }}</th>
                                        {{-- <th is='sortable' :column="'location_district'">{{ trans('admin.building.columns.location_district') }}</th> --}}
                                        <th is='sortable' :column="'location_street'">{{ trans('admin.building.columns.location_street') }}</th>
                                        {{-- <th is='sortable' :column="'location_gps'">{{ trans('admin.building.columns.location_gps') }}</th> --}}
                                        <th is='sortable' :column="'project_start_dates'">{{ trans('admin.building.columns.project_start_dates') }}</th>
                                        <th is='sortable' :column="'project_duration_dates'">{{ trans('admin.building.columns.project_duration_dates') }}</th>
                                        {{-- <th is='sortable' :column="'decade'">{{ trans('admin.building.columns.decade') }}</th> --}}
                                        {{-- <th is='sortable' :column="'style'">{{ trans('admin.building.columns.style') }}</th> --}}
                                        <th is='sortable' :column="'status'">{{ trans('admin.building.columns.status') }}</th>
                                        {{-- <th is='sortable' :column="'image_filename'">{{ trans('admin.building.columns.image_filename') }}</th> --}}

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="20">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/buildings')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/buildings/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                    <td>@{{ item.id }}</td>
                                        <td>@{{ item.source_id }}</td>
                                        <td>@{{ item.title }}</td>
                                        {{-- <td>@{{ item.title_alternatives }}</td> --}}
                                        {{-- <td>@{{ item.processed_date | date }}</td> --}}
                                        <td>@{{ item.architect_names }}</td>
                                        <td>@{{ item.builder }}</td>
                                        {{-- <td>@{{ item.builder_authority }}</td> --}}
                                        <td>@{{ item.location_city }}</td>
                                        {{-- <td>@{{ item.location_district }}</td> --}}
                                        <td>@{{ item.location_street }}</td>
                                        {{-- <td>@{{ item.location_gps }}</td> --}}
                                        <td>@{{ item.project_start_dates }}</td>
                                        <td>@{{ item.project_duration_dates }}</td>
                                        {{-- <td>@{{ item.decade }}</td> --}}
                                        {{-- <td>@{{ item.style }}</td> --}}
                                        <td>@{{ item.status }}</td>
                                        {{-- <td>@{{ item.image_filename }}</td> --}}
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/buildings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.building.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </building-listing>

@endsection