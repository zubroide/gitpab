@extends('partial.crud.edit', [
    'pageTitle' => __('messages.Edit payment'),
])

@section('form')

    <div class="row">
        <div class="col-md-6">
            <label>@lang('messages.Hours')</label>
            <p>{{ $object->hours }}</p>
        </div>
        <div class="col-md-6">
            <label>@lang('messages.Short comment')</label>
            <p>{{ $object->name ?: '-' }}</p>
        </div>
        <div class="col-md-6">
            <label>@lang('messages.Payment date')</label>
            <p>{{ $object->payment_date }}</p>
        </div>
        <div class="col-md-6">
            <label>@lang('messages.Employer')</label>
            <p>{{ $object->user->name }}</p>
        </div>
        <div class="col-md-6">
            @include('partial.form.element.select', [
                'name' => 'status_id',
                'label' => __('messages.Status'),
                'list' => $statusList,
                'selected' => $object->status_id,
            ])
        </div>
    </div>

@endsection