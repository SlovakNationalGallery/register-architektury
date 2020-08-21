@php
$height = $height ?? 'h-6rem h-sm-8rem';
$buildings_with_images = $buildings
    ->filter(fn ($building) => $building->processedImages->isNotEmpty());
@endphp
<div class="buildings-carousel {{ $height }} d-flex">
    <button class="prev-button btn btn-lg px-1 px-md-2 bg-white icon-chevron-left" disabled></button>
    <div class="carousel w-100">
        @foreach($buildings_with_images as $building)
        <a href="{{ $building->url }}" class="carousel-cell mr-1 mr-sm-2 mr-lg-3 d-block" title="{{ $building->title }}">
            <img
                data-flickity-lazyload-srcset="{{ $building->cover_image->getSrcset() }}"
                data-flickity-lazyload-src="{{ $building->cover_image->getUrl() }}"
                {{-- Initial size updated in JS --}}
                sizes="1px"
                class="{{ $height }}"
            >
        </a>
        @endforeach
    </div>
    <button class="next-button btn btn-lg px-1 px-md-2 bg-white icon-chevron-right" disabled></button>
</div>
