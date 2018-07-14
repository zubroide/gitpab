@extends('partial.crud.index', [
    'pageTitle' => 'Spent Time'
])

@section('contentTableControl')
@endsection

@section('contentTableFilter')
    @include('gitpab.time.index_filter_form')
@endsection

@section('contentTable')
    @include('gitpab.time.index_table', [
        'columnTitleName' => 'description'
    ])
@endsection

