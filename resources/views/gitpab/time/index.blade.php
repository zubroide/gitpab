@extends('partial.crud.index', [
    'pageTitle' => 'Spent Time'
])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.time.index_table', [
        'columnTitleName' => 'description'
    ])
@endsection

