@extends('partial.crud.show', ['pageTitle' => 'View issue'])

@section('form')

    <div class="row">
        <div class="col-md-2">
            ID
        </div>
        <div class="col-md-10">
            {{ $object->id }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Issue
        </div>
        <div class="col-md-10">
            <a href="{{ $object->issue->web_url ?? null }}">{{ $object->issue->iid ?? null}}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Text
        </div>
        <div class="col-md-10">
            {{ $object->body }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Author
        </div>
        <div class="col-md-10">
            {{ $object->author->name ?? null}}
        </div>
    </div>

@endsection