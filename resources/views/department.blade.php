@extends('layouts.app')
@section('title', html_entity_decode(__('header.about.department')))

@section('content')

@include('components.header')

<div class="container-fluid p-4">
    <div class="row pt-lg-7">
        <div class="col-lg-3 d-flex align-items-end">
            <p class="mb-4 mb-lg-0">{{ __('app.oa') }} {{ __('app.hu') }}<br/>{{ __('app.sav') }}</p>
        </div>
        <div class="col-lg-8 col-xl-6 d-flex align-items-end">
            <p class="mb-0">{{ __('about.department.intro') }}</p>
        </div>
    </div>
</div>
@endsection
