@extends('layouts.app')
@section('title', Str::upper(__('header.architects')))

@section('content')

@include('components.header')
<div class="container-fluid py-5 px-3 items">
    <form action="{{ route('architects.index') }}" id="filters">
        <div class="row">
            <div class="col-12 py-3">
                <ul class="d-flex justify-content-center flex-wrap px-0">
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
            <div class="col-12 py-5 mt-md-0">
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
            {{-- TODO --}}
            {{-- <div class="col-md-6 p-3 text-right">
                <span class="">{{ $buildings->total() }} {{ trans_choice('architects.objects', $buildings->total()) }}</span>
                <a href="{{ route('building.index', request()->merge(['sort_by' => 'oldest'])->all()) }}" class="link-no-underline ml-5">{{ __('building.sort.oldest') }} &darr;</a>
                <a href="{{ route('building.index', request()->merge(['sort_by' => 'newest'])->all()) }}" class="link-no-underline ml-5">{{ __('building.sort.newest') }} &uarr;</a>
            </div> --}}
        </div>
    </form>

    @foreach($architects as $architect)
    <div class="row border-top flex-nowrap py-2 item h-8rem">
        <div class="px-4 flex-shrink-0 w-8rem">
            @if($architect->has_image)
            <div style="background-image: url({{ $architect->getImageUrlForWidth(140) }})" class="use-background-image w-100 h-100"></div>
            @else
            {{-- Placeholder image --}}
            <div class="bg-secondary w-100 h-100"></div>
            @endif
        </div>
        <div class="d-inline-flex align-items-end pr-4 flex-sm-shrink-0">
            <h5 class="mb-0">{{ $architect->full_name }}</h5>
        </div>

        @php
        $flickity_settings = [
            'cellAlign' => 'left',
            'freeScroll' => true,
            'contain' => true,
            'prevNextButtons' => false,
            'pageDots' => false,
            'setGallerySize' => false,
            'imagesLoaded' => true,
        ];
        @endphp
        <div class="w-100 h-100 mr-4 d-none d-sm-block" data-flickity="{{ json_encode($flickity_settings) }}">
            @foreach($architect->buildings as $building)
                @if($building->processedImages->isNotEmpty())
                <img
                    src="{{ $building->getCoverImageUrlForHeight(80) }}"
                    srcset="{{ $building->getCoverImageUrlForHeight(80) }}, {{ $building->getCoverImageUrlForHeight(160) }} 2x"
                    class="h-100 mr-3"
                >
                @endif
            @endforeach
        </div>
    </div>
    @endforeach

</div>

<div class="col-md-12 p-3 text-center">
    {{ $architects->withQueryString()->links() }}
</div>
@endsection
