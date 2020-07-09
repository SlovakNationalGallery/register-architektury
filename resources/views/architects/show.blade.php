@extends('layouts.app')
@section('title', $architect->full_name)

@section('content')

@include('components.header')

<div class="container-fluid py-5 px-3">
    <div class="row">
        <div class="col-md-3 offset-md-3">
            <h2 class="mb-3 ls-2">
                {{ $architect->full_name }}
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="row">
                <div class="col-6 col-md-12 col-lg-5">
                @if($architect->has_image)
                {{ $architect->image_tag->attributes(['class' => 'mh-100 mw-100']) }}
                @endif
                </div>
            </div>
        </div>
        <div class="col-md-9 col-lg-3 mb-4">
            <ul class="list-group list-group-flush">
                <li class="list-group-item px-0 py-2 border-0">
                    <b>{{ __('architect.birth_death_date') }}</b><br>
                    {{ $architect->birth_date ?? '?' }} / {{ $architect->death_date ?? '?' }}
                </li>
                <li class="list-group-item px-0 py-2 border-0">
                    <b>{{ __('architect.birth_death_place') }}</b><br>
                    {{ $architect->birth_place ?? '?' }} / {{ $architect->death_place ?? '?' }}
                </li>
            </ul>
        </div>
        <div class="col-lg-6">
            {{ nl2br(strip_tags($architect->bio)) }}
        </div>
    </div>
</div>
{{-- related --}}
{{--
    <div class="container-fluid p-0 border-top">
    <div class="row no-gutters">
        <div class="col-md-12 p-3">
            {{ __('building.related') }} …
        </div>
        <div class="col-md-12 p-3">
            <div class="row no-gutters items">
                @foreach ($related_buildings as $i=>$building)
                    <div class="col-lg-3 col-sm-6 d-flex align-items-stretch item">
                        @include('components.building-card', ['building' => $building])
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12 p-3 text-center">
            {{ $related_buildings->withQueryString()->links() }}
        </div>
    </div>
</div> --}}
@endsection
