@extends('partial.crud.index', [
    'pageTitle' => __('messages.Spent Time')
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

