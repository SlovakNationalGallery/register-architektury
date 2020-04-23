@php
    $edit_url = url($crud->route.'/'.$entry->getKey().'/edit');
@endphp
<div class="media" style="white-space: normal">
    @if($entry->cover_image)
    <a href="{{ $edit_url }}">
        <img class="mr-3" src="{{ Storage::url($entry->cover_image) }}" width="80">
    </a>
    @endif
    <div class="media-bod small">
        <h5 class="mt-0"><a href="{{ $edit_url }}">{{ $entry->title }}</a></h5>
        {{ Str::limit(strip_tags($entry->description), 120) }}
    </div>
</div>
