@extends('layouts.app')
@section('title', Str::upper(__('header.architects')))

@section('content')

@include('components.header')
<div class="container-fluid py-5 px-0 items overflow-x-hidden">
    <form action="{{ route('architects.index') }}" id="filters">
        <div class="row">
            <div class="col-12 py-3">
                <ul class="d-flex justify-content-center flex-wrap px-0 mb-0">
                    @foreach (range('A', 'Z') as $letter)
                    @php
                        $extra_classes = [];
                        if (!$first_letters->contains($letter)) $extra_classes[] = 'disabled';
                        if (request('first_letter') == $letter) $extra_classes[] = 'active';
                    @endphp
                    <a class="position-relative mx-2 link-circle btn-link {{ implode(" ", $extra_classes) }}" href="{{ route('architects.index', ['first_letter' => $letter]) }}">
                        {{ $letter }}
                    </a>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-12 py-2 py-md-3 py-lg-5 mt-md-0">
                @include('components.timeline', [
                    'year_from' => request('year_from', $filter_values['year_min']),
                    'year_until' => request('year_until', $filter_values['year_max']),
                    'year_min' => $filter_values['year_min'],
                    'year_max' => $filter_values['year_max'],
                ])
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-md-6 p-3">
                @if(request('first_letter'))
                    @include('components.active-filter', [
                        'label' =>  __('filters.first_letter', ['letter' => request('first_letter')]),
                        'name' => 'first_letter',
                        'value' => request('first_letter'),
                    ])
                @endif
                @if (request('first_letter') || request('year_from') || request('year_until'))
                    <a href="{{ route('architects.index') }}" class="btn mb-2 btn-with-icon-right">
                    {{ trans('filters.clear') }} <span>&times;</span>
                    </a>
                @endif
            </div>
            <div class="col-md-6 p-3 pt-4 text-left text-sm-right">
                @include('components.sort-by', [
                    'count' => $architects->total(),
                    'count_translation_key' => 'architect.count',
                    'default_sort' => 'name_asc',
                ])
            </div>
        </div>
    </form>

    @foreach($architects as $architect)
    <div class="row border-top flex-nowrap py-2 item px-3">
        <div class="px-3 px-sm-4 flex-shrink-0 h-6rem h-sm-8rem d-flex align-items-end">
            @if($architect->has_image)
                {{ $architect->image_tag->attributes(['class' => 'h-100 w-auto']) }}
            @else
                <img src="{{ asset('images/no-image-architect.svg') }}" class="h-100" alt="{{ $architect->full_name }}">
            @endif
        </div>
        <div class="d-inline-flex align-items-end pr-1 pr-md-4 flex-sm-shrink-0">
            <h5 class="mb-0"><a href="{{ route('architects.show', $architect) }}" class="link-no-underline">{{ $architect->full_name }}</a></h5>
        </div>
        <div class="col-7 col-md px-0 px-md-2">
            @include('components.buildings-carousel', [
                'buildings' => $architect->buildings,
                'height' => 'h-6rem h-sm-8rem'
            ])
        </div>
    </div>
    @endforeach

</div>

<div class="col-md-12 p-3 text-center">
    {{ $architects->withQueryString()->links() }}
</div>
@endsection
