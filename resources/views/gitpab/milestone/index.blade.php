@extends('partial.crud.index', [
    'pageTitle' => 'Milestones'])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.milestone.index_table', [
        'columnTitleName' => 'title'
    ])
@endsection
