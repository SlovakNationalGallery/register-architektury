@php
// Set $default_sort to highlight implicit sorting
$current_sort = request('sort_by') ?? $default_sort ?? null;

$chronological_sort = $current_sort == 'newest' ? 'oldest' : 'newest';
$alphabetical_sort  = $current_sort == 'name_asc' ? 'name_desc' : 'name_asc';
@endphp

<span class="d-block d-sm-inline mb-2 mb-sm-0 text-nowrap mr-0 mr-md-3 mr-lg-5">{{ $count }} {{ trans_choice($count_translation_key, $count) }}</span>

@if (request()->filled('search'))
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => '']) }}" class="link-no-underline border-0 text-nowrap mr-2 mr-md-3 mr-lg-5">
        {{ __('filters.sort_by.relevance') }}
        <span class="icon-arrow-down {{ $current_sort == 'relevance' ? '' : 'text-secondary' }}"></span>
    </a>
@endif

<a href="{{ request()->fullUrlWithQuery(['sort_by' => $chronological_sort]) }}" class="link-no-underline border-0 text-nowrap mr-2 mr-md-3 mr-lg-5">
    {{ __('filters.sort_by.chronologically') }}
    <span class="icon-arrow-up {{ $current_sort == 'oldest' ? '' : 'text-secondary' }}"></span>
    <span class="icon-arrow-down {{ $current_sort == 'newest' ? '' : 'text-secondary' }}"></span>
</a>
<a href="{{ request()->fullUrlWithQuery(['sort_by' => $alphabetical_sort]) }}" class="link-no-underline border-0 text-nowrap mr-0">
    {{ __('filters.sort_by.alphabetically') }}
    <span class="icon-arrow-up {{ $current_sort == 'name_asc' ? '' : 'text-secondary' }}"></span>
    <span class="icon-arrow-down {{ $current_sort == 'name_desc' ? '' : 'text-secondary' }}"></span>
</a>
