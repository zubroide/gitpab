@extends('partial.table.base')

@php
$columnTitleName = isset($columnTitleName) ? $columnTitleName : 'name';
$columnTitleLabel = isset($columnTitleLabel) ? $columnTitleLabel : __('messages.Title');
@endphp

@section('tableThead')
    <tr>
        @include('partial.table.thcell', [
            'column' => 'note_id',
            'label' => __('messages.ID'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute,
        ])

        @include('partial.table.thcell', [
            'column' => 'created_at',
            'label' => __('messages.Spent at'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute,
        ])

        @include('partial.table.thcell', [
            'column' => 'hours',
            'label' => __('messages.Hours'),
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
            'label' => __('messages.Author'),
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
    </tr>
@endsection

@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-1">{{ $item->note_id }}</td>
            <td class="col-md-1">
                {{ \App\Helper\Date::formatDateTime($item->note->gitlab_created_at) }}
            </td>
            <td class="col-md-1">{{ $item->hours }}</td>
            <td class="col-md-5">
                <a href="{{ route('issue.show', [$item->note->issue]) }}">
                    #{{ $item->note->issue->iid }} {{ $item->note->issue->title }}
                </a>
                @if ((isset($columnTitleName)) ? $item->{$columnTitleName} : $item->title)
                    | <br/>
                    <a href="{{ route($showRoute, [$item->note_id]) }}">
                        {{ (isset($columnTitleName)) ? $item->{$columnTitleName} : $item->title }}
                    </a>
                @endif
            </td>
            <td class="col-md-2">
                {{ $item->note->author->name ?? null }}
            </td>
            <td class="col-md-1">
                {{ $item->note->issue->project->name ?? null }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="col-md-12">@lang('messages.Data not found')</td>
        </tr>
    @endforelse
@endsection

@section('tableTfooter')
    <tr>
        <td colspan="2"></td>
        <td>{{  $total['time'] }}</td>
        <td colspan="3"></td>
    </tr>
@endsection
