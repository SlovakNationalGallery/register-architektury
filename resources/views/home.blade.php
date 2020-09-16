@extends('layouts.app')
@section('title', __('app.title'))

@section('content')

@include('components.header')

<div class="container-fluid p-0 border-bottom">
    <div class="row px-3 justify-content-md-center">
        <div class="col-md-8 col-lg-6 py-4 py-md-5">
            <p class="lead text-center">{{ __('app.description') }}</p>
        </div>
    </div>
</div>

@include('components.map', [
    'center' => [19.696058, 48.6737532],
    'zoom' => 6,
    'show_map' => session('show_map', true),
])

<div class="container-fluid p-0">
    <div class="row px-3">
        <div class="col-md-12 p-3">
            <div class="row items px-3">
                {{-- TODO --}}
                @if($featured_filter)
                {{ $featured_filter->description }}
                @endif
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
