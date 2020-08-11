@php
    $captions = $captions ?? [];
@endphp
<div class="gallery-carousel-main overflow-hidden vh-38">
    @foreach($images as $index => $image)
    <div class="w-100 d-flex flex-column justify-content-center carousel-cell" data-caption="{{ Arr::get($captions, $index) }}">
        <img
            data-flickity-lazyload-srcset="{{ $image->getSrcset() }}"
            data-flickity-lazyload-src="{{ $image->getUrl() }}"
            sizes="(min-width: 768px) 40vw, 100vw"
            class="mh-100 mw-100 d-block mx-auto my-0"
        >
    </div>
    @endforeach
    <div class="caption position-absolute w-100 text-center p-2"></div>
    <button class="next-button btn btn-lg icon-chevron-right mr-1"></button>
    <button class="prev-button btn btn-lg icon-chevron-left ml-1"></button>
    <button class="fullscreen-exit-button btn btn-lg icon-close"></button>
</div>

<div class="gallery-carousel-nav h-6rem mt-4">
    @foreach($images as $image)
        {{ $image->img()->attributes(['width' => 'auto', 'class' => 'h-100 mr-3 pb-2 nav-slide']) }}
    @endforeach
</div>
