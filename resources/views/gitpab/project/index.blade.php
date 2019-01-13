@extends('partial.crud.index', [
    'pageTitle' => __('messages.Projects')
])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.project.index_table', [
        'columnTitleName' => 'name'
    ])
@endsection
