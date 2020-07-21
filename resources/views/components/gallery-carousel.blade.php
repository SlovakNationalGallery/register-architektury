@php
$main_carousel_settings = json_encode([
    'pageDots' => false,
    'setGallerySize' => false,
]);
@endphp
<div class="mb-4 gallery-carousel-main h-20rem" data-flickity="{{ $main_carousel_settings }}">
    @foreach($images as $image)
    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
        {{ $image->attributes(['width' => 'auto', 'class' => 'w-100 d-block']) }}
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
        {{ $image->attributes(['width' => 'auto', 'class' => 'h-100 mr-3 pb-2 nav-slide']) }}
    @endforeach
</div>
