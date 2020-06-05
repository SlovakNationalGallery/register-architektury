<div class="card m-3 border">
    <div class="card-body ls-1 pb-1">
        <img src="https://picsum.photos/500/300?grayscale&random={{ $building->id }}" class="card-img-top mb-4" alt="...">

        @include('components.tags', ['tags' => $building->tags])
        
    </div>
    <div class="card-footer bg-white ls-1 border-top-0 py-1">
        <p class="card-text">
            <a href="{{ $building->url }}" class="link-no-underline">{{ $building->title }}</a>
        </p>
    </div>
</div>