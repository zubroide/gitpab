@extends('partial.crud.index', [
    'pageTitle' => __('messages.Milestones')
])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.milestone.index_table', [
        'columnTitleName' => 'title'
    ])
@endsection
