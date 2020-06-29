<span class="">
    {{ ${$sort_for}->total() }} {{ trans_choice(Str::singular($sort_for).'.objects', ${$sort_for}->total()) }}
</span>
@foreach ($sort_by as $sort)
    <a href="{{ route(Str::singular($sort_for).'.index', request()->merge(['sort_by' => $sort])->all()) }}" class="link-no-underline ml-5">{{ __(Str::singular($sort_for).'.sort.' . $sort) }} &darr;</a>
@endforeach
