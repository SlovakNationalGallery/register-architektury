<div class="tags">
    @foreach ($tags as $tag)
        <a class="btn btn-outline-dark btn-sm mb-2" href="{{ route('building.index', ['filters[]' => $tag]) }}" role="button">{{ $tag }}</a>
    @endforeach
</div>
