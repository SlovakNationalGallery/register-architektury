@extends('layouts.app')
@section('title', $building->title)

@section('content')

@include('components.header')

<div class="container-fluid py-3 px-3 bg-light border-bottom" style="min-height: 350px"> 
  <div class="row">
      	<div class="col-sm-8">
	        <div class="tags">
	            @foreach ($building->tags as $tag)
	            <a class="btn btn-outline-dark btn-sm mb-2" href="./?search={{ $tag }}" role="button">{{ $tag }}</a>
	            @endforeach
	        </div>
	    </div>
    	<div class="col-sm-4 text-right">
        	<button class="btn btn-outline-dark btn-lg mb-2">MAPA</button>
      	</div>
	</div>
</div>

<div class="container-fluid py-5 px-3">	
    <div class="row">
        <div class="col-md-4">
            <p>
                <a href="#" class="link-no-underline">3D Model</a>
            </p>
            <img src="https://picsum.photos/500/300?grayscale&random={{ $building->id }}" class="card-img-top mb-4" alt="...">
        </div>
        <div class="col-md-4">
            <h2 class="mb-3 ls-2">
                {{ $building->title }}
            </h2>

            <ul class="list-group list-group-flush border-top border-bottom">
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.current_function') }}</b><br>
                  {{ $building->current_function }}
              </li>
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.address') }}</b><br>
                  {{ $building->location_street }}, {{ $building->location_city }}
              </li>
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.architects') }}</b><br>
                  {{ $building->architect_names }}
              </li>
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.builders') }}</b><br>
                  {{ $building->builder_authority }}
              </li>
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.competition_date') }}</b><br>
                  {{ $building->competition_date }}
              </li>
              <li class="list-group-item px-0 py-2">
                  <b>{{ __('building.project_date') }}</b><br>
                  {{ $building->project_duration_dates }}
              </li>
            </ul>
        </div>

        <div class="col-md-4">
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
