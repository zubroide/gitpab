<?php
$id = 'field_' . $name;
$label = isset($label) ? $label : $name;
$addLabel = isset($addLabel) ? $addLabel : 'Добавить';
$values = isset($values) ? $values : [];
$placeholder = (!empty($options['placeholder'])) ? $options['placeholder'] : '';
?>

<div id="{{ $id }}" class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label>{!! $label !!}</label>

    <button type="button" class="btn btn-default add_text_js"><i class="fa fa-plus"></i> {{ $addLabel }}
    </button>

    <br/><br/>

    <table class="table table-bordered" style="table-layout: fixed;">
        <tbody class="container_text_list_js"></tbody>
    </table>

    <span class="help-block">{{ $errors->first($name) }}</span>
</div>

<script id="{{ $name }}_tpl_text" type="text/x-handlebars-template">
    <tr data-id="<?= '{{id}}' ?>">
        <td>
            <input class="form-control field_text_js" style="width: 100%" name="{{ $name }}[]"
                   type="text" value="<?= '{{value}}' ?>" placeholder="{{ $placeholder }}">
            <input type="hidden" name="{{ $name . '_id' }}[]" value="<?=  '{{id}}' ?>" />
        </td>
        <td style="width: 53px;">
            <a href="<?= (!empty($options['deleteUrl'])) ? $options['deleteUrl'] . '/{{id}}' : '#' ?>"
               class="btn remove_text_js"
               data-token="{{ csrf_token() }}"
               data-confirm-msg="{{ (!empty($options['confirmMsg'])) ? $options['confirmMsg'] : '' }}">
                <i class="fa fa-remove"></i>
            </a>
        </td>
    </tr>
</script>

<script>
    $(function () {
        $("#{{$id}}").textList({
            'fieldname' : '{{ $name }}',
            'values' : {!! json_encode($values) !!}
        });
    });
</script>