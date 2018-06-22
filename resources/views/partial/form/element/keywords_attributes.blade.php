<?php
$id = 'field_' . $name;
$label = isset($label) ? $label : $name;
$mode = (!empty($mode) AND $mode == 'edit') ? 'edit' : 'create';
$confirmMsg = 'Вы действительно хотите удалить атрибут ключевой фразы? ВНИМАНИЕ!!! Все связи с материалами будут удалены!';
$value = (!empty($value)) ? $value : [];
?>

<div id="{{ $id }}" class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label>{!! $label !!}</label>

    <button type="button" class="btn btn-default add_attribute_js"><i class="fa fa-plus"></i> Добавить
    </button>
    @if ($name == 'attributes')
        <button type="button" class="btn btn-default add_abbreviation_js"> Завести сокращения атрибутов</button>
    @endif

    <br/><br/>

    <table class="table table-bordered" style="table-layout: fixed;">
        <tbody class="container_attributes_js"></tbody>
    </table>

    <span class="help-block">{{ $errors->first($name) }}</span>
</div>

<script id="{{ $name }}_tpl_attribute" type="text/x-handlebars-template">
    <tr>
        <td style="width: 40%">
            <input class="form-control field_name_js"
                   style="width: 100%"
                   name="{{ $name }}[@{{index}}][name]"
                   type="text"
                   value="<?= '{{name}}' ?>"
                   placeholder="Именительный падеж" />
        </td>
        <td>
            {!! view('admin.partial.form.element.inflects', [
                'name' => $name  . '[@{{index}}][inflects][]',
                'label' => 'Склонения',
                'options' => [
                    'extraClass' => 'field_inflects_js',
                    'skipJs' => true,
                ],
                'jsoptions' => [
                    'placeholder' => "Именительный падеж"
                ]
                ])->render() !!}
        </td>
        <td style="width: 53px;">
            <a href="<?= ($mode == 'edit') ? $deleteRoute . '/{{id}}' : '#' ?>"
               class="btn remove_attribute_js"
               data-token="{{ csrf_token() }}"
               data-confirm-msg="{{ ($mode == 'edit') ? $confirmMsg : '' }}">
                <i class="fa fa-remove"></i>
            </a>
        </td>
    </tr>
</script>

<script>
    $(function () {
        // Initialize Element
        $("#{{$id}}").keywordsAttributes({
            'fieldname': '<?= $name; ?>',
            'values': {!! json_encode($value) !!}
        });
    });
</script>