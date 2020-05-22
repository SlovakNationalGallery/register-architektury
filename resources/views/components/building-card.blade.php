<div class="card m-3 border-dark">
    <img src="https://picsum.photos/500/300?grayscale&random={{ $building->id }}" class="card-img-top" alt="...">
    <div class="card-body ls-1">
        <div class="mb-3 mt-2 tags">
            @foreach ($building->tags as $tag)
            <a class="btn btn-outline-dark btn-sm mb-2" href="./?search={{ $tag }}" role="button">{{ $tag }}</a>
            @endforeach
        </div>
        <p class="card-text">
            {{ $building->title }}
        </p>
    </div>
</div>