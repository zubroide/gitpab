<?php
$label = isset($label) ? $label : $name;
$_options = ['class' => 'form-control', 'style' => 'width: 100%'];
$options = isset($options) ? array_merge($_options, $options) : $_options;
?>

<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label>{!! $label !!}</label>

    {!! Form::password($name, $options) !!}

    <span class="help-block">{{ $errors->first($name) }}</span>
</div>