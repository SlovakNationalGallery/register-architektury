@php
// Set $default_sort to highlight implicit sorting
$current_sort = request('sort_by') ?? $default_sort ?? null;

$chronological_sort = $current_sort == 'newest' ? 'oldest' : 'newest';
$alphabetical_sort  = $current_sort == 'name_asc' ? 'name_desc' : 'name_asc';
@endphp

<span class="">{{ $count }} {{ trans_choice($count_translation_key, $count) }}</span>
<a href="{{ request()->fullUrlWithQuery(['sort_by' => $chronological_sort]) }}" class="link-no-underline ml-5">
    {{ __('filters.sort_by.chronologically') }}
    <span class="{{ $current_sort == 'oldest' ? '' : 'text-secondary' }}">&uarr;</span>
    <span class="{{ $current_sort == 'newest' ? '' : 'text-secondary' }}">&darr;</span>
</a>
<a href="{{ request()->fullUrlWithQuery(['sort_by' => $alphabetical_sort]) }}" class="link-no-underline ml-5">
    {{ __('filters.sort_by.alphabetically') }}
    <span class="{{ $current_sort == 'name_asc' ? '' : 'text-secondary' }}">&uarr;</span>
    <span class="{{ $current_sort == 'name_desc' ? '' : 'text-secondary' }}">&darr;</span>
</a>
