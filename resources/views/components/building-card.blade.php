<div class="card my-3 border">
    <div class="card-body ls-1 pb-1">
        <a href="{{ $building->url }}" class="image-link">
            @include('components.card-carousel', [
                'images' => $building->processedImages->map(fn ($image) => $image->getFirstMedia())
            ])
        </a>
        
        @include('components.tags', ['tags' => $building->tags])

    </div>
    <div class="card-footer bg-white ls-1 border-top-0 py-1">
        <p class="card-text">
            <a href="{{ $building->url }}" class="link-no-underline">{{ $building->title }}</a>
        </p>
    </div>
</div>
