<div class="card m-3 border">
    <div class="card-body ls-1 pb-1">
        <img src="https://picsum.photos/500/300?grayscale&random={{ $building->id }}" class="card-img-top mb-4" alt="...">

        <div class="tags">
            @foreach ($building->tags as $tag)
            <a class="btn btn-outline-dark btn-sm mb-2" href="./?search={{ $tag }}" role="button">{{ $tag }}</a>
            @endforeach
        </div>
        
    </div>
    <div class="card-footer bg-white ls-1 border-top-0 py-1">
        <p class="card-text">
            <a href="{{ $building->url }}" class="link-no-underline">{{ $building->title }}</a>
        </p>
    </div>
</div>