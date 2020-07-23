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

        <div class="col-md-3 order-md-2">
            <h2 class="mb-3 ls-2">
                {{ $building->title }}
            </h2>

            <ul class="list-group list-group-flush mb-4">
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
              @foreach($building->dates->groupBy('category') as $category => $dates)
              <li class="list-group-item px-0 py-2">
                <b>{{ Str::lower($category) }}</b><br>
                @foreach($dates as $date)
                {{ $date }}<br>
                @endforeach
              </li>
              @endforeach
            </ul>
        </div>

        <div class="col-md-3 order-md-1">
            <p>
                <a href="#" class="link-no-underline">3D Model</a>
            </p>
            @if($building->processedImages->isNotEmpty())
            @include('components.gallery-carousel', [
                'images' => $building->processedImages->map(fn ($image) => $image->getFirstMedia()->img())
            ])
            @endif
        </div>

        <div class="col-md-6 order-md-3">
            <h2 class="mb-3 ls-2">&nbsp;</h2>
            <div class="mt-2 py-2 expandable expandable-long">
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
{{-- related --}}
<div class="container-fluid px-3 border-top">
    <div class="row mb-4 mt-3">
        <div class="col text-left">
            {{ __('building.related') }} . . .
        </div>
    </div>
    <div class="row items">
        @foreach ($related_buildings as $building)
        <div class="col-lg-3 col-sm-6 d-flex align-items-stretch item">
            @include('components.building-card', ['building' => $building])
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            {{ $related_buildings->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
