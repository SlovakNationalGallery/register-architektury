@extends('layouts.app')
@section('title', __('app.title'))

@section('content')

@include('components.header')

<div class="container-fluid p-0">
    <div class="row no-gutters">
        <div class="col-md-6 p-3">[filters]</div>
        <div class="col-md-6 p-3 text-right">
            <span class="">{{ $buildings->total() }} {{ trans_choice('building.objects', $buildings->total()) }}</span>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-12 p-3">
            <div class="row no-gutters items">
                @foreach ($buildings as $i=>$building)
                    <div class="col-lg-3 col-sm-6 d-flex align-items-stretch item">
                        @include('components.building-card', ['building' => $building])
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    {{ $buildings->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
