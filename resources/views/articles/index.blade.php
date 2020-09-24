@extends('layouts.app')
@section('title', __('header.about.news'))

@section('content')
@include('components.header')

<div class="container-fluid my-md-5 my-lg-6 border-top">
    @foreach($articles as $article)
    <div class="row border-bottom py-3">
        <div class="col-lg-6 order-2 order-lg-1">
            <p class="mb-4">{{ $article->published_at->toDateString() }}</p>
            <h6 class="mb-4 font-weight-bold"><a href="{{ route('about.articles.show', $article) }}" class="link-no-underline">{{ $article->title }}</a></h6>
            <div class="expandable expandable-small expandable-no-link">
                {{ Str::words(strip_tags($article->content), 200) }}
            </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0 ">
            @if($article->hasMedia())
                {{ $article->getFirstMedia()->img()->attributes(['class' => 'h-16rem', 'width' => 'auto']) }}
            @endif
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
