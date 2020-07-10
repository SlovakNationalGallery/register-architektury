@extends('layouts.app')
@section('title', __('header.about.publications'))

@section('content')

@include('components.header')

<div class="container-fluid px-4 pt-7 pb-3">
    <div class="row">
        <div class="col text-right">
            @include('components.sort-by', [
                'count' => $publications->count(),
                'count_translation_key' => 'about.publications.count',
                'default_sort' => 'newest',
            ])
        </div>
    </div>
</div>
<div class="container-fluid pb-7">
    @foreach($publications as $publication)
    <div class="row border-top py-3">
        <div class="col-lg-3">
            <div class="row pb-4 pb-lg-0">
                <div class="col-6">
                    <img src="{{ Storage::url($publication->cover_image) }}" class="mw-100">
                </div>
                <div class="col-6 d-flex flex-column justify-content-end">
                    <h6 class="mb-4">{{ $publication->title }}</h6>
                    {{ $publication->authors }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex flex-column justify-content-end">
            {{ strip_tags($publication->description) }}
        </div>
    </div>
    @endforeach
</div>
@endsection
