@extends('partial.table.base')

@php
$columnTitleName = isset($columnTitleName) ? $columnTitleName : 'name';
$columnTitleLabel = isset($columnTitleLabel) ? $columnTitleLabel : 'Title';
$createdExist = isset($itemsList->first()['created_at']);
@endphp

@section('tableThead')
    <tr>
        @include('partial.table.thcell', [
            'column' => 'id',
            'label' => 'ID',
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute,
        ])

        @include('partial.table.thcell', [
            'column' => 'iid',
            'label' => 'Number',
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
            'column' => 'author',
            'label' => 'Author',
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'project',
            'label' => 'Project',
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @if ($createdExist)
            @include('partial.table.thcell', [
                'column' => 'created_at',
                'label' => 'Created At',
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
                {{ $item->author->name ?? null }}
            </td>
            <td class="col-md-2">
                {{ $item->issue->project->name ?? null }}
            </td>
            @if ($createdExist)
                <td class="col-md-2">
                    {{ $item->created_at }}
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="{{ $createdExist ? 4 : 3 }}" class="col-md-12">Data not found</td>
        </tr>
    @endforelse
@endsection