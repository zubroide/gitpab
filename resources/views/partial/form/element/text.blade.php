<?php
$isRequired = isset($isRequired) ? $isRequired : null;
$value = isset($value) ? $value : null;
$label = isset($label) ? $label : $name;
$help = isset($help) ? $help : null;
$error = $errors->first($name);
$_options = ['class' => 'form-control', 'style' => 'width: 100%'];
$options = isset($options) ? array_merge($_options, $options) : $_options;
?>

<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label>{{ $label }}{{ $isRequired ? ' *' : '' }}</label>

    {!! Form::text($name, $value, $options) !!}

    @if (!empty($error))
        <span class="help-block">{{ $error }}</span>
    @endif

    @if (!empty($help))
        <span class="help-block">{{ $help }}</span>
    @endif
</div>