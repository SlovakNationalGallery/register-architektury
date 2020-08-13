@extends('layouts.app')
@section('title', $architect->full_name)

@section('content')

@include('components.header')

<div class="container-fluid py-5 px-3">
    <div class="row">
        <div class="col-md-6 offset-md-6 col-lg-3 offset-lg-3">
            <h2 class="mb-3 ls-2">
                {{ $architect->full_name }}
            </h2>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-6 col-lg-3">
            <div class="row">
                <div class="col-10 col-sm-6 col-lg-8 col-xl-5">
                @if($architect->has_image)
                {{ $architect->image_tag->attributes(['class' => 'mh-100 mw-100']) }}
                @endif
                </div>
            </div>
        </div>
        <div class="mt-4 mt-md-0 col-md-6 col-lg-3 mb-4">
            <ul class="list-group list-group-flush">
                <li class="list-group-item p-0 border-0">
                    <b>{{ __('architect.birth_death_date') }}</b><br>
                    {{ $architect->birth_date ?? '?' }} / {{ $architect->death_date ?? '?' }}
                </li>
                <li class="list-group-item p-0 border-0">
                    <b>{{ __('architect.birth_death_place') }}</b><br>
                    {{ $architect->birth_place ?? '?' }} / {{ $architect->death_place ?? '?' }}
                </li>
            </ul>
        </div>
        <div class="mt-4 mt-lg-0 col-lg-6">
            {{ nl2br(strip_tags($architect->bio)) }}
        </div>
    </div>
    {{-- related buildings --}}
    <div class="row mt-5">
        <div class="col text-left text-sm-right">
            @include('components.sort-by', [
                'count' => $buildings->total(),
                'count_translation_key' => 'building.count',
                'default_sort' => (request()->filled('search')) ? 'relevance' : 'name_asc',
            ])
        </div>
    </div>
    <div class="row items">
        @foreach ($buildings as $building)
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

@endsection
