@extends('partial.table.base')
<?php
$columnTitleName = isset($columnTitleName) ? $columnTitleName : 'name';
$columnTitleLabel = isset($columnTitleLabel) ? $columnTitleLabel : __('messages.Title');
$createdExist = isset($itemsList->first()['created_at']);
?>
@section('tableThead')
    <tr>
        {!! view('partial.table.thcell', [
            'column' => 'id',
            'label' => __('messages.ID'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ]) !!}

        {!! view('partial.table.thcell', [
            'column' => $columnTitleName,
            'label' => $columnTitleLabel,
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ]) !!}

        @if ($createdExist)
            {!! view('partial.table.thcell', [
                'column' => 'created_at',
                'label' => __('messages.Created At'),
            ]) !!}
        @endif

        <th></th>
    </tr>
@endsection
@section('tableTbody')
    @forelse ($itemsList->items() as $key => $item)
        <tr>
            <td class="col-md-2">{{ $item->id }}</td>
            <td>
                <a href="{{ route($showRoute, [$item->id]) }}">
                    {{ (isset($columnTitleName)) ? $item->{$columnTitleName} : $item->title }}
                </a>
            </td>
            @if ($createdExist)
                <td class="col-md-2">
                    {{ $item->created_at }}
                </td>
            @endif
            <td class="table-action-column pull-right">
                @if (!$item->deleted_at)
                    <a href="{{ route($editRoute, [$item->id]) }}"
                       class="btn btn-xs text-success"
                       data-token="{{ csrf_token() }}">
                        <i class="fa fa-edit"></i>
                    </a>
                @endif
                @if (!$item->deleted_at)
                    <a href="{{ route($destroyRoute, [$item->id]) }}"
                       class="btn btn-xs text-danger crud_destroy_btn_js"
                       data-token="{{ csrf_token() }}"
                       data-confirm-msg="Do you really need to delete record?">
                        <i class="fa fa-remove"></i>
                    </a>
                @else
                    <a href="{{ route($restoreRoute, [$item->id]) }}"
                       class="btn btn-xs crud_restore_btn_js"
                       data-token="{{ csrf_token() }}"
                       data-confirm-msg="Do you really need to restore record?">
                        <i class="fa fa-recycle"></i>
                    </a>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="col-md-12">@lang('Data not found')</td>
        </tr>
    @endforelse
@endsection