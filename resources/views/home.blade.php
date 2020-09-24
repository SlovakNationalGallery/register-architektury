@extends('layouts.app')
@section('title', __('app.title'))

@section('content')

@include('components.header')

<div class="container-fluid p-0 border-bottom">
    <div class="row px-3 justify-content-md-center">
        <div class="col-md-8 col-lg-6 py-3 py-md-4">
            <p class="text-center m-0">{{ __('app.description') }}</p>
        </div>
    </div>
</div>

@include('components.map')

<div class="container-fluid p-0">
    <div class="row no-gutters">
        <div class="col-md-12 p-3" id="filters">
            {{-- featured filters --}}
            <form action="{{ route('building.index') }}">
                <div class="row no-gutters align-items-end">
                    <div class="col-md-6 p-3">
                        @if($featured_filter)
                            <p>{{ $featured_filter->description }}</p>
                            @include('components.tags', ['tags' => $featured_filter->tags])
                        @endif
                    </div>
                    <div class="col-md-6 p-3 pt-4 text-left text-sm-right">
                        @include('components.sort-by', [
                            'count' => $buildings->total(),
                            'count_translation_key' => 'building.count',
                            'default_sort' => 'name_asc',
                        ])
                    </div>
                </div>

            </form>
            {{-- /featured filters --}}

            <div class="row items px-3">
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
