@extends('layouts.app')
@section('title', $project->title)

@section('content')
@include('components.header')

<div class="container-fluid my-lg-7">
    @if($project->collection)
    <div class="row border-top pt-3">
        <div class="col">
            @include('components.buildings-carousel', [
                'buildings' => $project->collection->buildings,
                'height' => 'vh-md-25 vh-38',
            ])
        <p class="text-center my-4">
            <a href="{{ route('building.index', ['filter' => $project->collection->title]) }}">🡢 {{ __('collection.go_to_collection') }}</a>
        </p>
        </div>
    </div>
    @endif
    <div class="row border-top pt-3">
        <div class="col-lg-6 offset-lg-3">
            <h2 class="mb-2 ls-2">{{ $project->title }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 pt-4 lg-pt-0">
            <ul class="nav flex-column">
                @foreach($project->navigation_headings as $heading)
                <li class="nav-item pb-3">
                 <a href="{{ $heading->href }}"><h3>{{ $heading->text }}</h3></a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-lg-6 pt-4">
            {!! $project->contentHtml !!}
        </div>
        <div class="col-lg-3">
            @if($project->hasMedia())
                @include('components.gallery-carousel', [
                    'images' => $project->getMedia(),
                ])
            @endif
        </div>
    </div>
</div>


@endsection
