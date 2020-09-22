@if ($images->isEmpty())
    <div class="overflow-hidden vh-38 mb-2">
        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
            <img src="{{ asset('images/no-image-building.svg') }}" class="mh-100 mw-100 d-block mx-auto my-auto" alt="">
        </div>
    </div>
@else
<div class="card-carousel-main overflow-hidden vh-38 mb-2">
    @foreach($images as $index => $image)
    <div class="w-100 d-flex flex-column justify-content-center align-items-center carousel-cell">
        <img
            data-flickity-lazyload-srcset="{{ $image->getSrcset() }}"
            data-flickity-lazyload-src="{{ $image->getUrl() }}"
            sizes="(min-width: 768px) 40vw, 100vw"
            class="mh-100 mw-100 d-block mx-auto my-0"
        >
    </div>
    @endforeach
    {{-- <button class="next-button btn btn-lg icon-chevron-right mr-1"></button> --}}
    {{-- <button class="prev-button btn btn-lg icon-chevron-left ml-1"></button> --}}
</div>

@endif
