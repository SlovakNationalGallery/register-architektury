@extends('layouts.app')
@section('title', html_entity_decode(__('header.about.department')))

@section('content')

@include('components.header')

<div class="container-fluid px-4 pt-4">
    <div class="row pt-lg-7">
        <div class="col-lg-3 d-flex align-items-end">
            <p class="mb-4 mb-lg-0">{{ __('app.oa') }} {{ __('app.hu') }}<br/>{{ __('app.sav') }}</p>
        </div>
        <div class="col-lg-8 col-xl-6 d-flex align-items-end">
            <p class="mb-0">{{ __('about.department.intro') }}</p>
        </div>
    </div>
</div>
<div class="container-fluid mt-5 mt-lg-3 pb-4">
    <div class="row border-top py-3">
        <div class="col-8 col-lg-3 px-4 mb-4 mb-lg-0">
            <img src="https://placekitten.com/g/204/234" class="mw-100" alt="Henrieta Moravčíková">
        </div>
        <div class="col-lg-3 px-4 d-flex flex-column justify-content-end">
            <span>{{ __('about.department.head_of_department')}}</span>
            <h6 class="font-weight-bold">prof. Dr. Ing. arch. Henrieta Moravčíková</h6>
            <address>HÚ SAV, Dúbravská cesta 9, 845 03 Bratislava</address>
            <span>E-mail: <a href="mailto:henrieta.moravcikova@savba.sk">henrieta.moravcikova@savba.sk</a></span>
        </div>
    </div>
    <div class="row border-top py-3">
        <div class="col-8 col-lg-3 px-4 mb-4 mb-lg-0">
            <img src="https://placekitten.com/g/204/234" class="mw-100" alt="Katarína Haberlandová">
        </div>
        <div class="col-lg-3 px-4 d-flex flex-column justify-content-end">
            <span>{{ __('about.department.researcher_female')}}</span>
            <h6 class="font-weight-bold">PhDr. Katarína Haberlandová, PhD.</h6>
            <address>HÚ SAV, Dúbravská cesta 9, 845 03 Bratislava</address>
            <span>E-mail: <a href="mailto:katarina.haberlandova@savba.sk">katarina.haberlandova@savba.sk</a></span>
        </div>
    </div>
    <div class="row border-top py-3">
        <div class="col-8 col-lg-3 px-4 mb-4 mb-lg-0">
            <img src="https://placekitten.com/g/204/234" class="mw-100" alt="Peter Szalay">
        </div>
        <div class="col-lg-3 px-4 d-flex flex-column justify-content-end">
            <span>{{ __('about.department.researcher_male')}}</span>
            <h6 class="font-weight-bold">Peter Szalay, PhD.</h6>
            <address>HÚ SAV, Dúbravská cesta 9, 845 03 Bratislava</address>
            <span>E-mail: <a href="mailto:peter.szalay@savba.sk">peter.szalay@savba.sk</a></span>
        </div>
    </div>
    <div class="row border-top py-3">
        <div class="col-8 col-lg-3 px-4 mb-4 mb-lg-0">
            <img src="https://placekitten.com/g/204/234" class="mw-100" alt="Laura Pastoreková Krišteková">
        </div>
        <div class="col-lg-3 px-4 d-flex flex-column justify-content-end">
            <span>{{ __('about.department.researcher_female')}}</span>
            <h6 class="font-weight-bold">Ing. arch. Laura Pastoreková Krišteková, PhD.</h6>
            <address>HÚ SAV, Dúbravská cesta 9, 845 03 Bratislava</address>
            <span>E-mail: <a href="mailto:laura.pastorekova@savba.sk">laura.pastorekova@savba.sk</a></span>
        </div>
    </div>
</div>
@endsection
