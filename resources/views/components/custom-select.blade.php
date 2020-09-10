<select name="filters[]" class="border custom-select filter-select w-100" data-placeholder="{{ strtoupper($label) }}">
    <option value=""></option>
    @foreach ($data as $name=>$count)
        <option value="{{ $name }}">{{ ucfirst($name) }} [{{ $count }}]</option>
    @endforeach
</select>
