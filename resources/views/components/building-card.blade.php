@php
$images = $building->processedImages->map->getFirstMedia();
@endphp
<div class="building-card card my-4 border">
    <div class="vh-38 p-4">
    @if ($images->isEmpty())
        <a href="{{ $building->url }}" class="h-100 d-flex flex-column justify-content-center align-items-center">
            <img src="{{ asset('images/no-image-building.svg') }}" class="w-100">
        </a>
    @else
        <div class="card-carousel h-100">
            @foreach($images as $index => $image)
            <a href="{{ $building->url }}" class="carousel-cell w-100 h-100 d-flex justify-content-center align-items-center mx-3">
                <img
                    data-flickity-lazyload-srcset="{{ $image->getSrcset() }}"
                    data-flickity-lazyload-src="{{ $image->getUrl() }}"
                    sizes="1px" {{-- Initial size updated in JS --}}
                    class="mw-100 mh-100"
                >
            </a>
            @endforeach
            <button class="prev-button btn btn-lg icon-chevron-left" disabled></button>
            <button class="next-button btn btn-lg icon-chevron-right" disabled></button>
        </div>
    @endif
    </div>
    <div class="card-body ls-1 d-flex flex-column justify-content-between px-4 pb-4 pt-0">
        @include('components.tags', ['tags' => $building->tags])

        <p class="card-text pt-4">
            <a href="{{ $building->url }}" class="link-no-underline">{{ $building->title }}</a>
        </p>
    </div>
</div>
