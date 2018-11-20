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
            'column' => 'iid',
            'label' => __('messages.Number'),
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
            'column' => 'group',
            'label' => __('messages.Namespace'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'project',
            'label' => __('messages.Project'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @if ($createdExist)
            @include('partial.table.thcell', [
                'column' => 'gitlab_created_at',
                'label' => __('messages.Created At'),
            ])
        @endif
    </tr>
@endsection
@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-1">{{ $item->id }}</td>
            <td class="col-md-1">
                <a href="{{ $item->web_url }}">{{ $item->iid }}</a>
            </td>
            <td class="col-md-4">
                <a href="{{ route($showRoute, [$item->id]) }}">
                    {{ (isset($columnTitleName)) ? $item->{$columnTitleName} : $item->title }}
                </a>
            </td>
            <td class="col-md-2">
                {{ $item->group->name ?? null }}
            </td>
            <td class="col-md-2">
                {{ $item->project->name ?? null }}
            </td>
            @if ($createdExist)
                <td class="col-md-2">
                    {{ \App\Helper\Date::formatDateTime($item->gitlab_created_at) }}
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="{{ $createdExist ? 4 : 3 }}" class="col-md-12">@lang('messages.Data not found')</td>
        </tr>
    @endforelse
@endsection