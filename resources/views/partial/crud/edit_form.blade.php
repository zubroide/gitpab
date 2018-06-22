@extends('partial.form.base_create')

@section('formTag')
    {!! Form::open(array(
       'url' => route($updateRoute, [$object->id]),
       'method' => 'PATCH',
       'class' => 'ajaxform_js')) !!}
@endsection

@section('formButtons')
    <button name="submit" value="1" type="submit" class="btn btn-primary submit_form_ajax_b_js">
        Save
    </button>

    <button type="button" class="btn btn-default js_link" data-link="{{ $backUrl }}">Cancel</button>
@endsection