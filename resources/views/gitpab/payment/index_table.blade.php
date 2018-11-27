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
            'column' => 'hours',
            'label' => __('messages.Payed hours'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'user',
            'label' => __('messages.Employer'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => $columnTitleName,
            'label' => $columnTitleLabel,
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'status',
            'label' => __('messages.Status'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'payment_date',
            'label' => __('messages.Payment date'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @if ($createdExist)
            @include('partial.table.thcell', [
                'column' => 'created_at',
                'label' => __('messages.Created At'),
            ])
        @endif

        <th></th>
    </tr>
@endsection
@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-1">{{ $item->id }}</td>
            <td class="col-md-1">{{ $item->hours }}</td>
            <td class="col-md-2">{{ $item->user->name }}</td>
            <td class="col-md-2">{{ $item->name }}</td>
            <td class="col-md-1">@lang($item->status->title)</td>
            <td class="col-md-2">{{ $item->payment_date }}</td>
            @if ($createdExist)
                <td class="col-md-2">
                    {{ $item->created_at }}
                </td>
            @endif
            <td class="col-md-1">
                <a href="{{ route($editRoute, [$item->id]) }}"
                   class="btn btn-xs text-success"
                   data-token="{{ csrf_token() }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="{{ $createdExist ? 4 : 3 }}" class="col-md-12">@lang('messages.Data not found')</td>
        </tr>
    @endforelse
@endsection