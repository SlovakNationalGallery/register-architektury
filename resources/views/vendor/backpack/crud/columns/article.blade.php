@php
    $edit_url = url($crud->route.'/'.$entry->getKey().'/edit');
@endphp
<div class="media" style="white-space: normal">
    @if($entry->hasMedia())
    <a href="{{ $edit_url }}">
        {{ $entry->getFirstMedia()->img()->attributes(['width' => '80px', 'class' => 'm-3']) }}
    </a>
    @endif
    <div class="media-bod small">
        <h5 class="mt-0"><a href="{{ $edit_url }}">{{ $entry->title }}</a></h5>
        {{ Str::limit(strip_tags($entry->content), 120) }}
    </div>
</div>
