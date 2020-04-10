@php
    use Illuminate\Support\Carbon;
    $updated_at = $entry->updated_at
@endphp
@if(isset($updated_at))
<span title="{{ $updated_at }}">
    {!! Carbon::parse($updated_at)->diffForHumans() !!}
</span>
@endif
