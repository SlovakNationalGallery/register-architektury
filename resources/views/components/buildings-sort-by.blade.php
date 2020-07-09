<span class="">{{ $buildings->total() }} {{ trans_choice('building.count', $buildings->total()) }}</span>
<a href="{{ request()->fullUrlWithQuery(['sort_by' => 'oldest']) }}" class="link-no-underline ml-5">{{ __('building.sort.oldest') }} &darr;</a>
<a href="{{ request()->fullUrlWithQuery(['sort_by' => 'newest']) }}" class="link-no-underline ml-5">{{ __('building.sort.newest') }} &uarr;</a>
