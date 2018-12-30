@extends('partial.crud.edit', [
    'pageTitle' => __('messages.Edit user'),
])

@section('form')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                @include('partial.form.element.text', [
                    'name' => 'name',
                    'value' => $object->name,
                    'label' => __('messages.Name'),
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
                    'label' => __('messages.Roles'),
                ])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('partial.form.element.select', [
                'name' => 'contributor_id',
                'label' => __('messages.Employee'),
                'selected' => $object->contributor_id,
                'list' => $contributorList ?? [],
            ])
        </div>
    </div>

@endsection