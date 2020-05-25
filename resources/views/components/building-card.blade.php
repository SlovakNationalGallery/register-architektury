<div class="card m-3 border-dark">
    <img src="https://picsum.photos/500/300?grayscale&random={{ $building->id }}" class="card-img-top" alt="...">
    <div class="card-body ls-1 pb-1">
        <div class="mt-2 tags">
            @foreach ($building->tags as $tag)
            <a class="btn btn-outline-dark btn-sm mb-2" href="./?search={{ $tag }}" role="button">{{ $tag }}</a>
            @endforeach
        </div>
        
    </div>
    <div class="card-footer bg-white ls-1 border-top-0 py-1">
        <p class="card-text">
            {{ $building->title }}
        </p>
    </div>
</div>