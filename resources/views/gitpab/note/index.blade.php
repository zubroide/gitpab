@extends('partial.crud.index', [
    'pageTitle' => __('messages.Notes')
])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.note.index_table', [
        'columnTitleName' => 'body'
    ])
@endsection

