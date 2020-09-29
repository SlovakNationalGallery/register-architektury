@extends('layouts.app')
@section('title', $architect->full_name)

@section('content')

@include('components.header')

<div class="container-fluid py-5">
    <div class="row my-4">
        <div class="col-6 col-lg-3">
            <div class="border p-4 text-center w-100">
                @if($architect->has_image)
                    {{ $architect->image_tag->attributes(['class' => 'mw-100']) }}
                @else
                    {{-- Placeholder image --}}
                    <img src="{{ asset('images/no-image-architect.svg') }}" class="mh-100 mw-100" alt="{{ $architect->full_name }}">
                @endif
            </div>
        </div>
        <div class="mt-4 mt-md-0 col-md-6 col-lg-3 mb-4">
            <h2 class="mb-3 ls-2">
                {{ $architect->full_name }}
            </h2>

            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item px-0 py-2">
                    <b>{{ __('architect.birth') }}</b><br>
                    {{ $architect->birth_date ?? '?' }} {{ $architect->birth_place ?? '?' }}
                </li>
                @if ($architect->death_date || $architect->death_place)
                    <li class="list-group-item px-0 py-2">
                        <b>{{ __('architect.death') }}</b><br>
                        {{ $architect->death_date ?? '?' }} {{ $architect->death_place ?? '?' }}
                    </li>
                @endif
            </ul>
        </div>
        <div class="mt-4 mt-lg-0 col-lg-6">
            <div class="expandable">
                {{ nl2br(strip_tags($architect->bio)) }}
            </div>
        </div>
    </div>
    {{-- related buildings --}}
    <div class="row mt-5">
        <div class="col text-left text-sm-right">
            @include('components.sort-by', [
                'count' => $buildings->total(),
                'count_translation_key' => 'building.count',
                'default_sort' => 'name_asc',
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
