@extends('layouts.app')
@section('title', Str::upper(__('header.architects')))

@section('content')

@include('components.header')
<div class="container-fluid py-5 px-3 items">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1 py-3">
            <ul class="d-flex justify-content-center flex-wrap px-0">
                @foreach (range('A', 'Z') as $letter)
                <a class="border-0 px-4 py-2 btn-link{{ $first_letters->contains($letter) ? '' : ' disabled' }}" href="{{ route('architects.index', ['first_letter' => $letter]) }}">{{ $letter }}</a>
                @endforeach
            </ul>
        </div>
    </div>

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
        <div class="w-100 h-100 d-none d-sm-block" data-flickity="{{ json_encode($flickity_settings) }}">
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
