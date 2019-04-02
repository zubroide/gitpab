@extends('partial.crud.show', [
    'pageTitle' => __('messages.View contributor'),
])

@section('form')

    <div class="row">
        <div class="col-sm-10">

            <div class="row">
                <div class="col-md-3">
                    @lang('messages.ID')
                </div>
                <div class="col-md-9">
                    {{ $object->id }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @lang('messages.Employee')
                </div>
                <div class="col-md-9">
                    {{ $object->name }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @lang('messages.Username')
                </div>
                <div class="col-md-9">
                    <a href="{{ $object->web_url }}">{{ $object->username }}</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @lang('messages.Hour rate')
                </div>
                <div class="col-md-9">
                    {{ $object->extra ? $object->extra->hour_rate : '-' }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @lang('messages.Employee costs, %')
                </div>
                <div class="col-md-9">
                    {{ $object->extra ? $object->extra->costs_percent : '-' }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @lang('messages.Employer costs, %')
                </div>
                <div class="col-md-9">
                    {{ $object->extra ? $object->extra->taxes_percent : '-' }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    @lang('messages.Balance')
                </div>
                <div class="col-md-9">
                    <span
                            title="@lang('messages.Payed hours minus spent hours')"
                            class="label label-{{ $object->balance >= 0 ? 'success' : 'danger' }}">
                        {{ $object->balance }}
                    </span>
                </div>
            </div>

        </div>

        <div class="col-sm-2">
            @if ($object->avatar_url)
                <img src="{{ $object->avatar_url }}" class="card-avatar"/>
            @endif
        </div>
    </div>

@endsection
