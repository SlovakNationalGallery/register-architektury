@extends('layouts.app')
@section('title', Str::upper(__('header.collections')))

@section('content')

@include('components.header')

<div class="container-fluid pt-6 pb-3">
    <div class="row">
        <div class="col text-right">
            @include('components.sort-by', [
                'count' => $collections->total(),
                'count_translation_key' => 'collection.count',
                'default_sort' => 'newest',
            ])
        </div>
    </div>
</div>

<div class="container-fluid pb-6 items">
    @foreach($collections as $collection)
    <div class="row border-top py-2 item">
        <div class="col-lg-6">
            <h3 class="my-3"><a href="{{ route('building.index', ['filters[]' => $collection->title]) }}">{{ $collection->title }}</a></h3>
            <div class="expandable expandable-medium">
                @if($collection->project)
                <p class="">
                    <a href="{{ route('about.projects.show', $collection->project) }}" class="btn btn-outline-dark btn-sm">{{ __('collection.go_to_project') }}</a>
                </p>
                @endif
                {!! $collection->description !!}
            </div>
        </div>
        <div class="col-lg-6 py-4 py-md-0">
            @include('components.buildings-carousel', [
                'buildings' => $collection->buildings,
                'height' => 'h-8rem h-md-16rem',
            ])
        </div>
    </div>
    @endforeach
</div>

<div class="col-md-12 p-3 text-center">
    {{ $collections->withQueryString()->links() }}
</div>
@endsection
