<?php
$list = isset($list) ? $list : [];
$selected = isset($selected) ? $selected : null;
$label = isset($label) ? $label : $name;

$_options = ['class' => 'form-control select2', 'style' => 'width: 100%', 'multiple' => 'multiple'];
$options = isset($options) ? array_merge($_options, $options) : $_options;

$_jsoptions = ['tags' => true, 'multiple' => 'multiple', 'minimumResultsForSearch' => 'Infinity'];
$jsoptions = isset($jsoptions) ? array_merge($_jsoptions, $jsoptions) : $_jsoptions;
$jsoptions = json_encode($jsoptions);
?>

<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label>{!! $label !!}</label>

    {!! Form::select($name . '[]', $list, $selected, $options) !!}

    <span class="help-block">{{ $errors->first($name) }}</span>
</div>


<script>
    $(function () {
        //Initialize Select2 Elements
        $("select[name='{{ $name }}[]'].select2").select2({!! $jsoptions !!});
    });
</script>