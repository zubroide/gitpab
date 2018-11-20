@extends('partial.crud.show', ['pageTitle' => 'View issue'])

@section('form')

    <div class="row">
        <div class="col-md-2">
            @lang('messages.ID')
        </div>
        <div class="col-md-10">
            {{ $object->note_id }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Issue')
        </div>
        <div class="col-md-10">
            <a href="{{ $object->note->issue->web_url ?? null }}">{{ $object->note->issue->iid ?? null}}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Text')
        </div>
        <div class="col-md-10">
            {{ $object->description }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Author')
        </div>
        <div class="col-md-10">
            {{ $object->note->author->name ?? null}}
        </div>
    </div>

@endsection