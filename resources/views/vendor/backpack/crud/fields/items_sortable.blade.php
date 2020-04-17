<!-- items sortable -->
@php
    $old_ids = old(square_brackets_to_dots($field['name']));
    $values = $old_ids
        ? $field['model']::whereIn('id', $old_ids)->get()
        : $field['value'] ?? collect([]);

    $options = $field['model']::whereNotIn('id', $values->pluck('id'))->get();
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    <table class="table table-sm table-striped" id="table">
        <tbody>
        </tbody>
    </table>

    <div class="input-group">
    <select multiple id="items" class="form-control select2_multiple">
    @foreach ($options as $option)
        <option value="{{ $option->getKey() }}" data-preview="{{ asset($option->preview) }}">{{ $option->title }}</option>
    @endforeach
    </select>
    <span class="input-group-btn">
      <button id="addItems" class="btn btn-default"><i class="la la-plus"></i>&nbsp; add items</button>
    </span>
    </div><!-- /input-group -->

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}
    @push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD EXTRA JS --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
        <!-- include jquery-ui js-->
        <script src="{{ asset('packages/jquery-ui-dist/jquery-ui.min.js') }}"></script>
        @if (app()->getLocale() !== 'en')
            <script src="{{ asset('packages/select2/dist/js/i18n/' . app()->getLocale() . '.js') }}"></script>
        @endif

        <script>
            function addRow(id, value, previewUrl) {
                var preview_img = '';
                if (previewUrl) {
                    preview_img = `<img src="${previewUrl}" alt="" style="height: 50px; width: auto">`;
                }

                $('#table > tbody').append(`
                    <tr class="array-row item">
                        <input type="hidden" name="{{ $field['entity'] }}[]" value="${id}">
                        <td>${preview_img}</td>
                        <td>${value}</td>
                        <!-- <td><input class="sorter form-control" size="2" data-id="' + id + '" value="0" name="items_sort[' + id + ']"></td> -->\
                        <td><span class="btn btn-sm btn-light sort-handle pull-right ui-sortable-handle"><span class="sr-only">sort item</span><i class="la la-sort" role="presentation" aria-hidden="true"></i></span></td>\
                        <td><button data-id="${id}" class="btn btn-sm btn-light removeItem" type="button"><span class="sr-only">delete item</span><i class="la la-trash" role="presentation" aria-hidden="true"></i></button></td>\
                    </tr>`
                );
            }

            function reorder() {
                var i = 0;
                $("input.sorter").each(function() {
                    $(this).val(i);
                    i++;
                });
             }

            $(document).ready(function($) {
                @foreach ($values as $item)
                    addRow({{ $item->getKey() }}, '{{ $item->title }}');
                @endforeach

                // trigger select2 for each untriggered select2_multiple box
                $('.select2_multiple').each(function (i, obj) {
                    if (!$(obj).hasClass("select2-hidden-accessible"))
                    {
                        var $obj = $(obj).select2({
                            theme: "bootstrap"
                        });

                        var options = [];
                        @foreach ($options as $option)
                            options.push({{ $option->getKey() }});
                        @endforeach
                    }
                });

                $('#addItems').on('click', function (e) {
                    e.preventDefault();

                    $('#items  > option:selected').each(function() {
                        addRow($(this).val(), $(this).text(), $(this).data('preview'))
                     });
                    reorder();
                    $("#items").val([]).change();
                 });

                $('.removeItem').click(function () {
                    $(this).parent().parent().remove();
                    reorder();
                });

                $('#table tbody').sortable({
                    connectWith: "#items_sort option",
                    axis: "y",
                    handle: ".sort-handle",
                    placeholder: "array-row item item-placeholder ui-state-highlight",
                    cursor: "move",
                    opacity: 0.8,
                    update: function() {
                    reorder();
                    }
                }).disableSelection();

                $('input.sorter').on('keypress', function (e) {
                    if(e.key === "Enter"){
                        var position = $(this).val();
                        $(this).closest('tr').insertAfter($(`#table tbody tr:eq(${position})`));
                        reorder();
                        e.preventDefault();
                    }
                });
            });
        </script>
    @endpush
@endif
