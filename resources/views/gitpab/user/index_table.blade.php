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
            'column' => 'contributor_id',
            'label' => __('messages.Employee'),
        ])

        @include('partial.table.thcell', [
            'column' => 'email',
            'label' => __('messages.Email'),
            'order' => $order,
            'orderDirection' => $orderDirection,
            'orderLinkRoute' => $indexRoute
        ])

        @include('partial.table.thcell', [
            'column' => 'roles',
            'label' => __('messages.Roles'),
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
            <td class="col-md-1"><a href="{{ route('user.show', $item->id) }}">{{ $item->id }}</a></td>
            <td class="col-md-2">{{ $item->name }}</td>
            <td class="col-md-2">
                @include('partial.table.td-contributor', ['item' => $item->contributor])
            </td>
            <td class="col-md-2">{{ $item->email }}</td>
            <td class="col-md-2">
                @foreach ($item->roles as $role)
                    <span class="label label-primary">{{ $role->name }}</span>
                @endforeach
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
            <td colspan="{{ $createdExist ? 4 : 3 }}" class="col-md-12">@lang('messages.Data not found')</td>
        </tr>
    @endforelse
@endsection