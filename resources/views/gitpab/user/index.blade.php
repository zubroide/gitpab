@extends('partial.crud.index', [
    'pageTitle' => __('messages.Users')
])

@section('contentTableControl')
@endsection

@section('contentTable')
    @include('gitpab.user.index_table')
@endsection
