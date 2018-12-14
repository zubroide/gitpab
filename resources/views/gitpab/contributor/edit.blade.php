@extends('partial.crud.edit', [
    'pageTitle' => __('messages.Edit contributor'),
])

@section('form')

    <div class="row">
        <div class="col-md-6">
            <label>@lang('messages.Employer')</label>
            <p>{{ $object->name ?: '-' }}</p>
        </div>
        <div class="col-md-6">
            <label>@lang('messages.Username')</label>
            <p>{{ $object->username ?: '-' }}</p>
        </div>

        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'extra_hour_rate',
                'label' => __('messages.Hour rate'),
                'value' => $object->extra ? $object->extra->hour_rate : '',
            ])
        </div>

        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'extra_costs_percent',
                'label' => __('messages.Costs, %'),
                'value' => $object->extra ? $object->extra->costs_percent : '',
            ])
        </div>

    </div>

@endsection