@extends('partial.crud.show', ['pageTitle' => 'View project'])

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
            Name
        </div>
        <div class="col-md-10">
            {{ $object->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Email
        </div>
        <div class="col-md-10">
            {{ $object->email }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            Created at
        </div>
        <div class="col-md-10">
            {{ $object->created_at }}
        </div>
    </div>

@endsection