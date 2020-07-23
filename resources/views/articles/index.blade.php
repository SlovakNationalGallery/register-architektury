@extends('layouts.app')
@section('title', __('header.about.news'))

@section('content')
@include('components.header')

<div class="container-fluid my-lg-7">
    @foreach($articles as $article)
    <div class="row border-bottom py-3">
        <div class="col-lg-6 order-2 order-lg-1">
            <p class="mb-4">{{ $article->published_at->toDateString() }}</p>
            <a href="{{ route('about.articles.show', $article) }}"><h6 class="mb-4 font-weight-bold">{{ $article->title }}</h6></a>
            {{ Str::words(strip_tags($article->content), 100) }}
        </div>
        <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0 ">
            <img src="{{ Storage::url($article->cover_image) }}" class="mw-100 mvh-30">
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col text-center">
            {{ $articles->withQueryString()->links() }}
        </div>
    </div>
</div>


@endsection
