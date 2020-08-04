@php
$main_carousel_settings = json_encode([
    'pageDots' => false,
    'lazyLoad' => 2,
]);
@endphp
<div class="mb-4 gallery-carousel-main overflow-hidden vh-38" data-flickity="{{ $main_carousel_settings }}">
    @foreach($images as $image)
    <div class="vh-38 w-100">
        <img
            data-flickity-lazyload-srcset="{{ $image->getSrcset() }}"
            data-flickity-lazyload-src="{{ $image->getUrl() }}"
            sizes="(min-width: 768px) 40vw, 100vw"
            class="mh-100 mw-100 d-block mx-auto my-0"
        >
    </div>
    @endforeach
</div>


@php
$nav_carousel_settings = json_encode([
    'cellAlign' => 'left',
    'freeScroll' => true,
    'contain' => true,
    'prevNextButtons' => false,
    'pageDots' => false,
    'setGallerySize' => false,
    'asNavFor' => '.gallery-carousel-main'
]);
@endphp
<div class="h-6rem gallery-carousel-nav" data-flickity="{{ $nav_carousel_settings }}">
    @foreach($images as $image)
        {{ $image->img()->attributes(['width' => 'auto', 'class' => 'h-100 mr-3 pb-2 nav-slide']) }}
    @endforeach
</div>
