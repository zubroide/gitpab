@extends('partial.crud.create', [
    'pageTitle' => __('messages.Create payment')
])

@section('form')

    <div class="row">
        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'hours',
                'label' => __('messages.Payed hours'),
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'title',
                'label' => __('messages.Short comment'),
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.select', [
                'name' => 'user_id',
                'label' => __('messages.Employer'),
                'list' => $userList ?? [],
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.select', [
                'name' => 'status_id',
                'label' => __('messages.Status'),
                'list' => $statusList ?? [],
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.date', [
                'name' => 'payment_date',
                'label' => __('messages.Payment date'),
            ])
        </div>
        <div class="col-md-12">
            @include('partial.form.element.textarea', [
                'name' => 'description',
                'label' => __('messages.Description'),
                'options' => [
                    'rows' => 5,
                ],
            ])
        </div>
    </div>

@endsection