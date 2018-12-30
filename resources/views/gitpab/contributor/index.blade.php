@extends('partial.crud.index', [
    'pageTitle' => __('messages.Contributors')
])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.contributor.index_table', [
        'columnTitleName' => 'body',
        'columnTitleLabel' => __('messages.Employee'),
    ])
@endsection

