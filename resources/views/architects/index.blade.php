@extends('layouts.app')
@section('title', Str::upper(__('header.architects')))

@section('content')

@include('components.header')

<div class="container-fluid py-5 px-3">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <ul class="list-group list-group-horizontal d-flex justify-content-center">
                @foreach (range('A', 'Z') as $letter)
                <a class="list-group-item border-0 mx-1" href="#{{ $letter }}">{{ $letter }}</a>
                @endforeach
            </ul>
        </div>
    </div>


</div>
@endsection
