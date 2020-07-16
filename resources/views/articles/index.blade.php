@extends('layouts.app')
@section('title', __('header.about.news'))

@section('content')
@include('components.header')

<div class="container-fluid my-7 border-top">
    @foreach($articles as $article)
    <div class="row border-bottom py-3">
        <div class="col-lg-6 order-2 order-lg-1">
            <p class="mb-4">{{ $article->published_at->toDateString() }}</p>
            <h6 class="mb-4 font-weight-bold">{{ $article->title }}</h6>
            {{ Str::words(strip_tags($article->content), 100) }}
        </div>
        <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0 ">
            <img src="{{ Storage::url($article->cover_image) }}" class="mw-100 mvh-30">
        </div>
    </div>
    @endforeach
</div>

@endsection
