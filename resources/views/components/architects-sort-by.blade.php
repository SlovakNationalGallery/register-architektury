<span class="">{{ $architects->total() }} {{ trans_choice('architect.count', $architects->total()) }}</span>
<a href="{{ request()->fullUrlWithQuery(['sort_by' => 'oldest']) }}" class="link-no-underline ml-5">{{ __('architect.sort.oldest') }} &darr;</a>
<a href="{{ request()->fullUrlWithQuery(['sort_by' => 'newest']) }}" class="link-no-underline ml-5">{{ __('architect.sort.newest') }} &uarr;</a>
