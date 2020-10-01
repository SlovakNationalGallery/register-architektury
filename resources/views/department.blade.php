@extends('layouts.app')
@section('title', __('header.about.department_page_title'))

@section('content')

@include('components.header')

<div class="container-fluid pt-md-5 pt-lg-6 border-bottom pb-3">
    <div class="row">
        <div class="col-lg-3 d-flex align-items-end">
            <p class="mb-4 mb-lg-0">{{ __('app.oa') }} {{ __('app.hu') }}<br/>{{ __('app.sav') }}</p>
        </div>
        <div class="col-lg-8 col-xl-6">
            <p class="">{{ __('about.department.intro') }}</p>
            <p class="mb-0">{{ __('about.department.established') }}</p>
        </div>
    </div>
</div>
<div class="container-fluid pb-4 pb-lg-6">
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
    <div class="row border-bottom py-3">
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
