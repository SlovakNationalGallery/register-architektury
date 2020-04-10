@php
    use Illuminate\Support\Carbon;
    $published_at = $entry->published_at
@endphp
@if(!isset($published_at))
    Draft
@else
<span title="{{ $published_at }}">
    {!! Carbon::parse($published_at)->diffForHumans() !!}
</span>
@endif
