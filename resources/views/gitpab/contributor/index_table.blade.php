@extends('partial.table.base')

@php
$columnTitleName = isset($columnTitleName) ? $columnTitleName : 'name';
$columnTitleLabel = isset($columnTitleLabel) ? $columnTitleLabel : __('messages.Title');
$createdExist = isset($itemsList->first()['created_at']);
@endphp

@section('tableThead')
    <tr>
        @include('partial.table.thcell', [
            'column' => 'id',
            'label' => __('messages.ID'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute,
        ])

        @include('partial.table.thcell', [
            'column' => $columnTitleName,
            'label' => $columnTitleLabel,
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'username',
            'label' => __('messages.Username'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'balance',
            'label' => __('messages.Balance'),
            'title' => __('messages.Payed hours minus spent hours'),
        ])

        @include('partial.table.thcell', [
            'column' => 'created_at',
            'label' => __('messages.Created At'),
        ])
    </tr>
@endsection
@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-1">{{ $item->id }}</td>
            <td class="col-md-4">{{ $item->name }}</td>
            <td class="col-md-3">
                <a href="{{ $item->web_url }}">{{ $item->username }}</a>
            </td>
            <td class="col-md-2">
                <span
                        title="@lang('messages.Payed hours minus spent hours')"
                        class="label label-{{ $item->balance >= 0 ? 'success' : 'danger' }}">
                    {{ $item->balance }}
                </span>
            </td>
            @if ($createdExist)
                <td class="col-md-2">
                    {{ $item->created_at }}
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="{{ $createdExist ? 4 : 3 }}" class="col-md-12">@lang('messages.Data not found')</td>
        </tr>
    @endforelse
@endsection