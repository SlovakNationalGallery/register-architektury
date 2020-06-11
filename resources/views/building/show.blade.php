@extends('layouts.app')
@section('title', $building->title)

@section('content')

@include('components.header')

@include('components.map', [
    'location' => $building->lng_lat,
    'tags' => $building->tags,
    'show_map' => session('show_map', true),
])

<div class="container-fluid py-5 px-3">
    <div class="row">

        <div class="col-md-4 order-md-2">
            <h2 class="mb-3 ls-2">
                {{ $building->title }}
            </h2>

            <ul class="list-group list-group-flush border-top border-bottom mb-4">
              @if (!empty($building->current_function))
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.current_function') }}</b><br>
                  {{ $building->current_function }}
              </li>
              @endif
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.address') }}</b><br>
                  {{ implode(', ', [$building->location_street, $building->location_city]) }}
              </li>
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.architects') }}</b><br>
                  {{ $building->architect_names }}
              </li>
              @if (!empty($building->builder_authority))
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.builders') }}</b><br>
                  {{ $building->builder_authority }}
              </li>
              @endif
              @if (!empty($building->project_start_dates))
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.project_start_dates') }}</b><br>
                  {!! implode('<br>', $building->project_start_dates_array) !!}
              </li>
              @endif
              @if (!empty($building->project_duration_dates))
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.project_duration_dates') }}</b><br>
                  {!! implode('<br>', $building->project_duration_dates_array) !!}
              </li>
              @endif
            </ul>
        </div>

        <div class="col-md-4 order-md-1">
            <p>
                <a href="#" class="link-no-underline">3D Model</a>
            </p>
            @if($building->processedImages->isNotEmpty())
            {{ $building->cover_image_tag->attributes(['class' => 'card-img-top mb-4']) }}
            @endif
        </div>

        <div class="col-md-4 order-md-3">
            <h2 class="mb-3 ls-2">&nbsp;</h2>
            <div class="border-bottom border-top mt-2 py-2">
                <p>
                    {!! nl2br($building->description) !!}
                </p>
                <p>
                    {{ __('building.bibliography') }}:
                </p>
                <p>
                    {!! nl2br($building->bibliography) !!}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
