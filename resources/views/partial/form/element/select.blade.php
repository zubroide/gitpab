<?php
$list = isset($list) ? $list : [];
$selected = isset($selected) ? $selected : null;
$label = isset($label) ? $label : $name;

$_options = [
    'class' => 'form-control select2',
    'style' => 'width: 100%',
];
$options = isset($options) ? array_merge($_options, $options) : $_options;
if (!empty($options['extraClass']))
{
    $options['class'] .= ' ' . $options['extraClass'];
    unset($options['extraClass']);
}

$_jsoptions = [
    'placeholder' => '',
];

$jsoptions = isset($jsoptions) ? array_merge($_jsoptions, $jsoptions) : $_jsoptions;
// Для автокомплита добавляем кнопку сброса
if (array_key_exists('data-ajax--url', $options))
{
    $jsoptions['allowClear'] = true;
}
$jsoptions = json_encode($jsoptions);
?>

<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label>{!! $label !!}</label>

    {!! Form::select($name, $list, $selected, $options) !!}

    <span class="help-block">{{ $errors->first($name) }}</span>
</div>


<script>
    $(function () {
        //Initialize Select2 Elements
        $("select[name='{{ $name }}'].select2").select2({!! $jsoptions !!});
    });
</script>