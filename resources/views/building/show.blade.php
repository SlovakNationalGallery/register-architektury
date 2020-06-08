@extends('layouts.app')
@section('title', $building->title)

@section('content')

@include('components.header')

<div class="container-fluid py-3 px-3 bg-light border-bottom vh-38"> 
    <div class="row">
    	<div class="col-sm-4 order-sm-2 text-sm-right">
        	<button class="btn btn-outline-dark btn-lg mb-2">MAPA</button>
     	</div>
        <div class="col-sm-8 order-sm-1">
            @include('components.tags', ['tags' => $building->tags])
        </div>
	</div>
</div>

<div class="container-fluid py-5 px-3">	
    <div class="row">

        <div class="col-md-4 order-md-2">
            <h2 class="mb-3 ls-2">
                {{ $building->title }}
            </h2>

            <ul class="list-group list-group-flush border-top border-bottom mb-4">
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.current_function') }}</b><br>
                  {{ $building->current_function }}
              </li>
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.address') }}</b><br>
                  {{ implode(', ', [$building->location_street, $building->location_city] }}
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
              @if (!empty($building->project_competition_dates))
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.competition_date') }}</b><br>
                  {{ $building->project_competition_dates }}
              </li>
              @endif
              @if (!empty($building->project_duration_dates))
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.project_date') }}</b><br>
                  {!! implode('<br>', $building->project_dates) !!}
              </li>
              @endif
            </ul>
        </div>

        <div class="col-md-4 order-md-1">
            <p>
                <a href="#" class="link-no-underline">3D Model</a>
            </p>
            <img src="{{ $building->preview_img }}" class="card-img-top mb-4" alt="...">
        </div>

        <div class="col-md-4 order-md-3">
            <h2 class="mb-3 ls-2">&nbsp;</h2>
            <div class="border-bottom border-top mt-2 py-2">
                <p>
                    {!! nl2br($building->description_formated) !!}
                </p>
                <p>
                    {{ __('building.bibliography') }}:
                </p>
                <p>
                    {!! nl2br($building->bibliography_formated) !!}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
