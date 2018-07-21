@extends('partial.crud.edit', ['pageTitle' => 'Edit project'])

@section('form')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                @include('partial.form.element.text', [
                    'name' => 'name',
                    'value' => $object->name,
                    'label' => 'Name',
                    'isRequired' => true,
                ])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                @include('partial.form.element.select', [
                    'name' => 'roles[]',
                    'list' => $rolesList,
                    'selected' => $object->roles,
                    'options' => ['multiple' => 'multiple'],
                    'label' => 'Roles',
                ])
            </div>
        </div>
    </div>

@endsection