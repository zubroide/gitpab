@extends('partial.crud.index', [
    'pageTitle' => 'Issues'
])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.issue.index_table', [
        'columnTitleName' => 'title'
    ])
@endsection

