@extends('partial.crud.show', [
    'pageTitle' => __('messages.View payment')
])

@section('form')

    <div class="row">
        <div class="col-md-2">
            @lang('messages.ID')
        </div>
        <div class="col-md-10">
            {{ $object->id }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Short comment')
        </div>
        <div class="col-md-10">
            {{ $object->title }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Payed hours')
        </div>
        <div class="col-md-10">
            {{ $object->hours }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Employer')
        </div>
        <div class="col-md-10">
            {{ $object->contributor->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Description')
        </div>
        <div class="col-md-10">
            {{ $object->description }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Payment date')
        </div>
        <div class="col-md-10">
            {{ $object->payment_date }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Created At')
        </div>
        <div class="col-md-10">
            {{ $object->created_at }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Created By')
        </div>
        <div class="col-md-10">
            {{ $object->created_by->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Updated At')
        </div>
        <div class="col-md-10">
            {{ $object->updated_at }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Updated By')
        </div>
        <div class="col-md-10">
            {{ $object->updated_by->name }}
        </div>
    </div>

@endsection