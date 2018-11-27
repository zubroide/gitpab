@extends('partial.crud.index', [
    'pageTitle' => __('messages.Payments')
])

@section('contentTableControl')
    <a class="btn btn-primary" href="{{ route('payment.create')  }}">@lang('messages.Create')</a>
@endsection

@section('contentTable')
    @include('gitpab.payment.index_table', [
        'columnTitleLabel' => __('messages.Short comment')
    ])
@endsection

