@php
$buildings_with_images = $architect->buildings
    ->filter(fn ($building) => $building->processedImages->isNotEmpty());

@endphp
<div class="buildings-carousel h-8rem w-100 d-flex">
    <button class="prev-button btn btn-lg bg-white icon-chevron-left" disabled></button>
    <div class="carousel w-100">
        @foreach($buildings_with_images as $building)
        <a href="{{ $building->url }}" class="carousel-cell mr-3" title="{{ $building->title }}">
            {{ $building->cover_image_tag->attributes(['width' => 'auto', 'class' => 'h-100']) }}
        </a>
        @endforeach
    </div>
    <button class="next-button btn btn-lg bg-white icon-chevron-right" disabled></button>
</div>
