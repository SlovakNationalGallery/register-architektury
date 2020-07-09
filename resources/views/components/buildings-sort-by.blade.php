<span class="">{{ $buildings->total() }} {{ trans_choice('building.count', $buildings->total()) }}</span>
<a href="{{ route('building.index', request()->merge(['sort_by' => 'oldest'])->all()) }}" class="link-no-underline ml-5">{{ __('building.sort.oldest') }} &darr;</a>
<a href="{{ route('building.index', request()->merge(['sort_by' => 'newest'])->all()) }}" class="link-no-underline ml-5">{{ __('building.sort.newest') }} &uarr;</a>
