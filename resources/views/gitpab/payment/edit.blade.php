@extends('partial.crud.edit', [
    'pageTitle' => __('messages.Edit payment'),
])

@section('form')

    <div class="row">
        <div class="col-md-6">
            <label>@lang('messages.Amount')</label>
            <p>{{ $object->amount ?: '-' }}</p>
        </div>
        <div class="col-md-6">
            <label>@lang('messages.Hour rate')</label>
            <p>{{ $object->hour_rate ?: '-' }}</p>
        </div>
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <label>@lang('messages.Employee costs, %')</label>
            <p>{{ $object->costs_percent ?: '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label>@lang('messages.Payed hours')</label>
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
            <label>@lang('messages.Employee')</label>
            <p>{{ $object->contributor->name }}</p>
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