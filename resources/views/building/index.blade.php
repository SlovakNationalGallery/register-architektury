@extends('layouts.app')
@section('title', __('app.title'))

@section('content')

@include('components.header')

<div class="container-fluid p-0">
    <div class="row no-gutters">
        <div class="col-md-12 p-3">

            {{-- filters --}}
            <div class="row no-gutters">
                <div class="col-md-6 p-3">
                    @foreach (request('filters', []) as $filter)
                        <button class="btn btn-outline-dark btn-sm mb-2 btn-with-icon-right">
                          {{ $filter }}<span>&times;</span>
                        </button>
                        <input type="hidden" name="filters[]" value="{{ $filter }}">
                    @endforeach
                    @if (request('filters'))
                        <button class="btn mb-2 btn-with-icon-right">
                          Zrušiť všetky filtre<span>&times;</span>
                        </button>
                    @endif
                </div>
                <div class="col-md-6 p-3 text-right">
                    <span class="">{{ $buildings->total() }} {{ trans_choice('building.objects', $buildings->total()) }}</span>
                    <a href="{{ route('building.index', ['sort_by' => 'oldest']) }}" class="link-no-underline ml-5">{{ __('building.sort.oldest') }} &darr;</a>
                    <a href="{{ route('building.index', ['sort_by' => 'newest']) }}" class="link-no-underline ml-5">{{ __('building.sort.newest') }} &uarr;</a>
                </div>
            </div>
            {{-- /filters --}}

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
