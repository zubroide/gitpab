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
            Number
        </div>
        <div class="col-md-10">
            {{ $object->iid }}
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
            Web url
        </div>
        <div class="col-md-10">
            <a href="{{ $object->web_url }}">{{ $object->web_url }}</a>
        </div>
    </div>

    <hr/>

<pre>
## Changelog

@foreach ($object->issues as $issue)
- {{ $issue->title . '  ' }}
  #{{ $issue->iid }} ({{ $issue->project->name }})
@endforeach
</pre>

@endsection