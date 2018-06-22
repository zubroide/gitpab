<?php
$list = isset($list) ? $list : [];
$selected = isset($selected) ? $selected : null;

$_options = ['class' => 'form-control select2 select2-hidden', 'multiple' => 'multiple', 'style' => 'width:99%'];
$options = isset($options) ? array_merge($_options, $options) : $_options;
if (isset($options['extraClass']))
{
    $options['class'] .= ' ' . $options['extraClass'];
}
$includeJs = (empty($options['skipJs']) OR !$options['skipJs']) ? true : false;

$_jsoptions = [
    'tags' => true,
    'multiple' => 'multiple',
    'minimumResultsForSearch' => 'Infinity',
    'dropdownCssClass' => 'select2-hidden',
];
$jsoptions = isset($jsoptions) ? array_merge($_jsoptions, $jsoptions) : $_jsoptions;
$jsoptions = json_encode($jsoptions);
?>


<div class="input-group no-padding inflects_list_js">
    {!! Form::select($name, $list, $selected, $options) !!}
    <span class="input-group-btn">
        <button type="button" class="btn btn-default fill_inflects_js"
                data-url="{{ url('keyword/generate_inflects', ['phrase' => 'phrase']) }}">
            Заполнить
        </button>
    </span>
</div>

<span class="help-block">{{ $errors->first($name) }}</span>

@if ($includeJs)
    <script>
        $(function () {
            //Initialize Select2 Elements
            $("select[name='{{ $name }}'].select2").select2({!! $jsoptions !!});
            $("select[name='{{ $name }}'].select2").closest('.inflects_list_js').inflectsList({
                'source': function()
                {
                    return $('[name="name"]').val();
                }
            });
        });
    </script>
@endif