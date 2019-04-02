@extends('partial.table.base')

@php
$columnTitleName = isset($columnTitleName) ? $columnTitleName : 'name';
$columnTitleLabel = isset($columnTitleLabel) ? $columnTitleLabel : __('messages.Title');
$orderLinkParams = $request->all();
unset($orderLinkParams['submit']);
@endphp

@section('tableThead')
    <tr>
        @include('partial.table.thcell', [
            'column' => 'id',
            'label' => __('messages.ID'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute,
            'orderLinkParams' => $orderLinkParams,
        ])

        @include('partial.table.thcell', [
            'column' => $columnTitleName,
            'label' => $columnTitleLabel,
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute,
            'orderLinkParams' => $orderLinkParams,
        ])

        @include('partial.table.thcell', [
            'column' => 'estimate',
            'label' => __('messages.Estimate'),
        ])

        @include('partial.table.thcell', [
            'column' => 'spent',
            'label' => __('messages.Spent time'),
        ])

        @if (\Illuminate\Support\Facades\Auth::user()->hasPermissionTo(\App\User::PERMISSION_PROJECT_FINANCES))
            @include('partial.table.thcell', [
                'column' => 'spent',
                'label' => __('messages.Amount'),
            ])
        @endif

        @include('partial.table.thcell', [
            'column' => 'gitlab_created_at',
            'label' => __('messages.Created At'),
        ])
    </tr>
@endsection
@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-1">{{ $item->id }}</td>
            <td class="col-md-3">
                <a href="{{ route($showRoute, [$item->id]) }}">
                    {{ (isset($columnTitleName)) ? $item->{$columnTitleName} : $item->title }}
                </a>
            </td>
            <td class="col-md-2">
                {{ $item->estimate }}
            </td>
            <td class="col-md-2">
                {{ $item->spent }}
            </td>
            @if (\Illuminate\Support\Facades\Auth::user()->hasPermissionTo(\App\User::PERMISSION_PROJECT_FINANCES))
                <td class="col-md-2">
                    {{ $item->amount }}
                </td>
            @endif
            <td class="col-md-2">
                {{ \App\Helper\Date::formatDateTime($item->gitlab_created_at) }}
            </td>
        </tr>
    @empty
        <tr>
            @if (\Illuminate\Support\Facades\Auth::user()->hasPermissionTo(\App\User::PERMISSION_PROJECT_FINANCES))
                <td colspan="6" class="col-md-12">@lang('messages.Data not found')</td>
            @else
                <td colspan="5" class="col-md-12">@lang('messages.Data not found')</td>
            @endif
        </tr>
    @endforelse
@endsection