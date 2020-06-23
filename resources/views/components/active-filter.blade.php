<label class="btn btn-outline-dark btn-sm mb-2 btn-with-icon-right" for="filter-{{ Str::slug($filter) }}">
    {{ $filter }}<span>&times;</span>
    <input type="checkbox" name="filters[]" value="{{ $filter }}" id="filter-{{ Str::slug($filter) }}" checked="checked" class="d-none">
</label>