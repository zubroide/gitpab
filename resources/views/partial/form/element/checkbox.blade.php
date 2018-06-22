<?php
$value = isset($value) ? $value : 1;
$checked = isset($checked) ? $checked : false;
$label = isset($label) ? $label : $name;
?>

<div class="checkbox icheck {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::hidden($name, 0) !!}
    <label>{!! Form::checkbox($name, $value, $checked) !!} {!! $label !!}</label>
    <span class="help-block">{{ $errors->first($name) }}</span>
</div>

<script>

    $(function () {
        $('input[name={{$name}}]').iCheck({
            checkboxClass: 'icheckbox_minimal',
            radioClass: 'iradio_minimal',
            increaseArea: '20%' // optional
        });
    });

</script>