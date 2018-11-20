@extends('partial.crud.edit', ['pageTitle' => 'Edit project'])

@section('form')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'name',
                    'value' => $object->name,
                    'label' => __('messages.Name'),
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
    </div>

@endsection