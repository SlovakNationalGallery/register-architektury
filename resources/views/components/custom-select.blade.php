<select name="filters[]" class="border custom-select filter-select w-100" data-placeholder="{{ $label }}">
    <option value=""></option>
    @foreach ($data as $name=>$count)
        <option value="{{ $name }}">{{ $name }} [{{ $count }}]</option>
    @endforeach
</select>