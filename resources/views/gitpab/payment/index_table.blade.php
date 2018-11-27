@extends('partial.table.base')

@php
$columnTitleName = isset($columnTitleName) ? $columnTitleName : 'name';
$columnTitleLabel = isset($columnTitleLabel) ? $columnTitleLabel : __('messages.Title');
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

        @include('partial.table.thcell', [
            'column' => 'created_at',
            'label' => __('messages.Created At'),
        ])

        @include('partial.table.thcell', [
            'column' => 'updated_at',
            'label' => __('messages.Updated At'),
        ])

        <th></th>
    </tr>
@endsection
@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-1"><a href="{{ route('payment.show', $item->id) }}">{{ $item->id }}</a></td>
            <td class="col-md-1">{{ $item->hours }}</td>
            <td class="col-md-2">{{ $item->contributor->name }}</td>
            <td class="col-md-2">{{ $item->title }}</td>
            <td class="col-md-1">@lang($item->status->title)</td>
            <td class="col-md-1">{{ $item->payment_date }}</td>
            <td class="col-md-1">
                {{ $item->created_at }} /
                {{ $item->created_by->name }}
            </td>
            <td class="col-md-1">
                {{ $item->updated_at }} /
                {{ $item->updated_by->name }}
            </td>
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