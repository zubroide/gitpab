@extends('partial.crud.show', [
    'pageTitle' => __('messages.View contributor'),
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
            @lang('messages.Issue')
        </div>
        <div class="col-md-10">
            <a href="{{ $object->issue->web_url ?? null }}">{{ $object->issue->iid ?? null}}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Text')
        </div>
        <div class="col-md-10">
            {{ $object->body }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Author')
        </div>
        <div class="col-md-10">
            {{ $object->author->name ?? null}}
        </div>
    </div>

@endsection