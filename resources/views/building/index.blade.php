@extends('layouts.app')
@section('title', __('app.title'))

@section('content')

@include('components.header')

<div class="container-fluid p-0">
    <div class="row no-gutters">
        <div class="col-md-12 p-3" id="filters">
            {{-- filters --}}
            <form action="{{ route('building.index') }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <div class="row no-gutters">
                    <div class="col-md p-3">
                        @include('components.custom-select', ['data' => $filter_values['architects'], 'label' => trans('filters.architect')])
                    </div>
                    <div class="col-md p-3">
                        @include('components.custom-select', ['data' => $filter_values['locations'], 'label' => trans('filters.location')])
                    </div>
                    <div class="col-md p-3">
                        @include('components.custom-select', ['data' => $filter_values['functions'], 'label' => trans('filters.function')])
                    </div>
                </div>

                <div class="row no-gutters">
                    <div class="col-12 py-5 mt-md-0">
                        @include('components.timeline', [
                            'year_from' => request('year_from', $filter_values['year_min']),
                            'year_until' => request('year_until', $filter_values['year_max']),
                            'year_min' => $filter_values['year_min'],
                            'year_max' => $filter_values['year_max'],
                        ])
                    </div>
                </div>

                <div class="row no-gutters">
                    <div class="col-md-6 p-3">
                        @foreach (request('filters', []) as $filter)
                            @include('components.active-filter', [
                                'label' => $filter,
                                'name' => 'filters[]',
                                'value' => $filter,
                            ])
                        @endforeach
                        @if (request('filters'))
                            <a href="{{ route('building.index') }}" class="btn mb-2 btn-with-icon-right">
                              {{ trans('filters.clear') }} <span>&times;</span>
                            </a>
                        @endif
                    </div>
                    <div class="col-md-6 p-3 text-right">
                        @include('components.sort-by', ['sort_for' => 'buildings', 'sort_by' => ['oldest', 'newest']])
                    </div>
                </div>

            </form>
            {{-- /filters --}}

            <div class="row no-gutters items">
                @foreach ($buildings as $i=>$building)
                    <div class="col-lg-3 col-sm-6 d-flex align-items-stretch item">
                        @include('components.building-card', ['building' => $building])
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    {{ $buildings->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
