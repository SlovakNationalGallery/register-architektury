@extends('layouts.app')
@section('title', __('app.title'))

@section('content')

@include('components.header')

<div class="container-fluid p-0">
    <div class="row no-gutters">
        <div class="col-md-12 p-3" id="filters">
            {{-- filters --}}
            <form action="{{ route('building.index') }}">
                <div class="row no-gutters">
                    <div class="col-md p-3">
                        <select name="filters[]" class="border custom-select" data-placeholder="{{ trans('filters.architect') }}">
                          <option value=""></option>
                          @foreach ($architects as $architect=>$count)
                              <option value="{{ $architect }}">{{ $architect }} ({{ $count }})</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-md p-3">
                        <select name="filters[]" class="border custom-select" data-placeholder="{{ trans('filters.location') }}">
                          <option value=""></option>
                          @foreach ($locations as $location=>$count)
                              <option value="{{ $location }}">{{ $location }} ({{ $count }})</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-md p-3">
                        <select name="filters[]" class="border custom-select" data-placeholder="{{ trans('filters.function') }}">
                          <option value=""></option>
                          @foreach ($functions as $function=>$count)
                              <option value="{{ $function }}">{{ $function }} ({{ $count }})</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-6 p-3">

                        @foreach (request('filters', []) as $filter)
                            @include('components.active-filter', ['filter' => $filter])
                        @endforeach

                        @if (request('filters'))
                            <a href="{{ route('building.index') }}" class="btn mb-2 btn-with-icon-right">
                              {{ trans('filters.clear') }} <span>&times;</span>
                            </a>
                        @endif

                    </div>
                    <div class="col-md-6 p-3 text-right">
                        <span class="">{{ $buildings->total() }} {{ trans_choice('building.objects', $buildings->total()) }}</span>
                        <a href="{{ route('building.index', ['sort_by' => 'oldest']) }}" class="link-no-underline ml-5">{{ __('building.sort.oldest') }} &darr;</a>
                        <a href="{{ route('building.index', ['sort_by' => 'newest']) }}" class="link-no-underline ml-5">{{ __('building.sort.newest') }} &uarr;</a>
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
