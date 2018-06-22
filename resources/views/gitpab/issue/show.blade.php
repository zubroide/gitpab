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
            Title
        </div>
        <div class="col-md-10">
            {{ $object->title }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Description
        </div>
        <div class="col-md-10">
            {{ $object->description }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Assignee
        </div>
        <div class="col-md-10">
            {{ $object->assignee->name ?? null }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Web url
        </div>
        <div class="col-md-10">
            <a href="{{ $object->web_url }}">{{ $object->web_url }}</a>
        </div>
    </div>

@endsection