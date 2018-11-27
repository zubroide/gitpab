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
            @lang('messages.Title')
        </div>
        <div class="col-md-10">
            {{ $object->title }}
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
            @lang('messages.Status')
        </div>
        <div class="col-md-10">
            {{ $object->status->title }}
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

@endsection