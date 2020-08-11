@php
$buildings_with_images = $architect->buildings
    ->filter(fn ($building) => $building->processedImages->isNotEmpty());
@endphp
<div class="buildings-carousel h-8rem w-100 d-flex">
    <button class="prev-button btn btn-lg bg-white icon-chevron-left" disabled></button>
    <div class="carousel w-100">
        @foreach($buildings_with_images as $building)
        <a href="{{ $building->url }}" class="carousel-cell mr-3 d-block" title="{{ $building->title }}">
            <img
                data-flickity-lazyload-srcset="{{ $building->cover_image->getSrcset() }}"
                data-flickity-lazyload-src="{{ $building->cover_image->getUrl() }}"
                {{-- Initial size updated in JS --}}
                sizes="1px"
                class="h-8rem"
            >
        </a>
        @endforeach
    </div>
    <button class="next-button btn btn-lg bg-white icon-chevron-right" disabled></button>
</div>
