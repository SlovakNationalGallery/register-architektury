@if ($images->isEmpty())
    <div class="vh-38 mb-2">
        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
            <img src="{{ asset('images/no-image-building.svg') }}" class="mh-100 mw-100 d-block mx-auto my-auto" alt="">
        </div>
    </div>
@else
<div class="card-carousel vh-38 mb-2">
    @foreach($images as $index => $image)
    <div class="w-100 h-100 d-flex justify-content-center align-items-center carousel-cell">
        <img
            data-flickity-lazyload-srcset="{{ $image->getSrcset() }}"
            data-flickity-lazyload-src="{{ $image->getUrl() }}"
            sizes="1px" {{-- Initial size updated in JS --}}
            class="mh-100 align-self-center"
        >
    </div>
    @endforeach
    <button class="prev-button btn btn-lg px-2 icon-chevron-left" disabled></button>
    <button class="next-button btn btn-lg px-2 icon-chevron-right" disabled></button>
</div>

@endif
