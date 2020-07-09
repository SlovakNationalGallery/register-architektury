<span class="">{{ $architects->total() }} {{ trans_choice('architect.count', $architects->total()) }}</span>
<a href="{{ route('architects.index', request()->merge(['sort_by' => 'oldest'])->all()) }}" class="link-no-underline ml-5">{{ __('architect.sort.oldest') }} &darr;</a>
<a href="{{ route('architects.index', request()->merge(['sort_by' => 'newest'])->all()) }}" class="link-no-underline ml-5">{{ __('architect.sort.newest') }} &uarr;</a>
