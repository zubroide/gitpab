@extends('partial.crud.show', ['pageTitle' => 'View project'])

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
            {{ $object->name }}
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
            @lang('messages.Path with namespace')
        </div>
        <div class="col-md-10">
            {{ $object->path_with_namespace }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Web url')
        </div>
        <div class="col-md-10">
            <a href="{{ $object->web_url }}">{{ $object->web_url }}</a>
        </div>
    </div>

@endsection