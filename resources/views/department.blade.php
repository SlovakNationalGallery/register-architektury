@extends('layouts.app')
@section('title', __('header.about.department_page_title'))

@section('content')

@include('components.header')

@if(Route::is('about.*'))
<div class="row no-gutters">
    <div class="col-md-12">
        <nav class="nav nav-justified sub-nav bg-light align-items-stretch mt-n1">
            <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.department') ? 'active' : '' }}" href="{{ route('about.department') }}">{!! __('header.about.department') !!}</a>
            <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.articles.*') ? 'active' : '' }}" href="{{ route('about.articles.index') }}">{{ __('header.about.news') }}</a>
            <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.projects.*') ? 'active' : '' }}" href="{{ route('about.projects.index') }}">{{ __('header.about.projects') }}</a>
            <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.publications') ? 'active' : '' }}" href="{{ route('about.publications') }}">{{ __('header.about.publications') }}</a>
        </nav>
    </div>
</div>
@endif

<div class="container-fluid px-4 pt-4 pt-lg-7">
    <div class="row">
        <div class="col-lg-3 d-flex align-items-end">
            <p class="mb-4 mb-lg-0">{{ __('app.oa') }} {{ __('app.hu') }}<br/>{{ __('app.sav') }}</p>
        </div>
        <div class="col-lg-8 col-xl-6 d-flex align-items-end">
            <p class="mb-0">{{ __('about.department.intro') }}</p>
        </div>
    </div>
</div>
<div class="container-fluid mt-5 mt-lg-3 pb-4 pb-lg-7">
    @php
    $people = [
        (object) [
            'name' => 'prof. Dr. Ing. arch. Henrieta Moravčíková',
            'image_url' => asset('images/henrieta-moravcikova.jpg'),
            'role' => __('about.department.head_of_department'),
            'email' => 'henrieta.moravcikova@savba.sk',
        ],
        (object) [
            'name' => 'PhDr. Katarína Haberlandová, PhD.',
            'image_url' => asset('images/katarina-haberlandova.jpg'),
            'role' => __('about.department.researcher_female'),
            'email' => 'katarina.haberlandova@savba.sk',
        ],
        (object) [
            'name' => 'Peter Szalay, PhD.',
            'image_url' => asset('images/peter-szalay.jpg'),
            'role' => __('about.department.researcher_male'),
            'email' => 'peter.szalay@savba.sk',
        ],
        (object) [
            'name' => 'Ing. arch. Laura Pastoreková Krišteková, PhD.',
            'image_url' => asset('images/laura-pastorekova.jpg'),
            'role' => __('about.department.researcher_female'),
            'email' => 'laura.pastorekova@savba.sk'
        ],
    ];
    @endphp
    @foreach($people as $person)
    <div class="row border-top py-3">
        <div class="col-8 col-lg-3 px-4 mb-3 mb-lg-0">
            <img src="{{ $person->image_url }}" class="mw-100" alt="{{ $person->name }}">
        </div>
        <div class="col-lg-3 px-4 d-flex flex-column justify-content-end">
            <span>{{ $person->role }}</span>
            <h6 class="font-weight-bold">{{ $person->name }}</h6>
            <address class="mb-0">HÚ SAV, Dúbravská cesta 9, 845 03 Bratislava</address>
            <span>E-mail: <a href="mailto:{{ $person->email }}">{{ $person->email }}</a></span>
        </div>
    </div>
    @endforeach
</div>
@endsection
