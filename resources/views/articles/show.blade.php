@extends('layouts.app')
@section('title', $article->title)

@section('content')
@include('components.header')

<div class="container-fluid my-lg-7">
    <div class="row border-top pt-3">
        <div class="col-lg-6 offset-lg-3">
            <h2 class="mb-2 ls-2">{{ $article->title }}</h2>
            <span>{{ $article->published_at->toDateString() }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <ul class="nav flex-column">
                <li class="nav-item pb-3">
                    <a href="#TODO"><h3>KOMPARATÍVNE ŠTÚDIE</h3></a>
                </li>
                <li class="nav-item pb-3">
                    <a href="#TODO"><h3>PRÍPADOVÉ ŠTÚDIE</h3></a>
                </li>
                <li class="nav-item pb-3">
                    <a href="#TODO"><h3>FOTO</h3></a>
                </li>
                <li class="nav-item pb-3">
                    <a href="#TODO"><h3>PRESS</h3></a>
                </li>
            </ul>
        </div>
        <div class="col-lg-6 pt-4">
            {!! $article->content !!}
        </div>
    </div>
</div>


@endsection
