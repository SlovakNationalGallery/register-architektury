@extends('layouts.app')
@section('title', __('app.title'))

@section('content')

@include('components.header')

<div class="container-fluid p-0">	
    <div class="row no-gutters">
        <div class="col-md-12 border border-dark p-3">
            <div class="row no-gutters">
                @foreach ($buildings as $i=>$building)
                    <div class="col-md-4 d-flex align-items-stretch">
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
