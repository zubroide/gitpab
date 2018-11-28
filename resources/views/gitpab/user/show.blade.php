@extends('partial.crud.show', [
    'pageTitle' => __('messages.View user')
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
            @lang('messages.Name')
        </div>
        <div class="col-md-10">
            {{ $object->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Employer')
        </div>
        <div class="col-md-10">
            {{ $item->contributor ? $item->contributor->name : '' }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Email')
        </div>
        <div class="col-md-10">
            {{ $object->email }}
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