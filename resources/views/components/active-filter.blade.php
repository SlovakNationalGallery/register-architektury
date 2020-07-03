<label class="btn btn-outline-dark btn-sm mb-2 btn-with-icon-right" for="filter-{{ Str::slug($name) }}">
    {{ $label }}<span>&times;</span>
    <input type="checkbox" name="{{ $name }}" value="{{ $value }}" id="filter-{{ Str::slug($name) }}" checked="checked" class="d-none">
</label>
