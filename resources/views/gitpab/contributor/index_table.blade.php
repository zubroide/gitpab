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
            'column' => 'extra_hour_rate',
            'label' => __('messages.Hour rate'),
            'title' => __('messages.Money per hour'),
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

        <th></th>
    </tr>
@endsection
@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-1"><a href="{{ route('contributor.show', $item->id) }}">{{ $item->id }}</a></td>
            <td class="col-md-4">
                @include('partial.table.td-contributor', ['item' => $item])
            </td>
            <td class="col-md-2">
                <a href="{{ $item->web_url }}">{{ $item->username }}</a>
            </td>
            <td class="col-md-1">
                {{ $item->extra ? $item->extra->hour_rate : '-' }}
            </td>
            <td class="col-md-1">
                <span
                        title="@lang('messages.Payed hours minus spent hours')"
                        class="label label-{{ $item->balance >= 0 ? 'success' : 'danger' }}">
                    {{ $item->balance }}
                </span>
            </td>
            <td class="col-md-2">
                {{ $item->created_at }}
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
            <td colspan="7" class="col-md-12">@lang('messages.Data not found')</td>
        </tr>
    @endforelse
@endsection