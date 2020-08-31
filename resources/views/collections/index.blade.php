@extends('layouts.app')
@section('title', Str::upper(__('header.collections')))

@section('content')

@include('components.header')

<div class="container-fluid px-4 pt-7 pb-3">
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

<div class="container-fluid pb-7 px-3 items">
    @foreach($collections as $collection)
    <div class="row border-top py-2 item">
        <div class="col-lg-6">
            <h5><a href="#TODO">{{ $collection->title }}</a></h5>
            {!! $collection->description !!}
        </div>
        <div class="col-lg-6">
            @include('components.buildings-carousel', [
                'buildings' => $collection->buildings,
                'height' => 'vh-md-25 h-6rem',
            ])
        </div>
    </div>
    @endforeach
</div>

<div class="col-md-12 p-3 text-center">
    {{ $collections->withQueryString()->links() }}
</div>
@endsection
