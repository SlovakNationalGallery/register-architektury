@extends('layouts.app')

@php
  $title = 'Error '.$error_number;
@endphp

@section('content')

@include('components.header')

<div class="container-fluid p-0 bg-light h-100">
    <div class="row no-gutters h-100">
      <div class="col-md-12 text-center">
        <div class="error_number ls-3">
          ERROR<br>
          {{ $error_number }}
        </div>
        <div class="error_title my-4">
          @yield('title')
        </div>
        <a href="/" class="btn btn-outline-dark my-5 view-more-button px-5">{{ __('app.return_home') }}</a>
      </div>
    </div>
</div>
@endsection