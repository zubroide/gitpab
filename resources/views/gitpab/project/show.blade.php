@extends('partial.crud.show', [
    'pageTitle' => __('messages.View project'),
])

@section('form')

    <div class="row">
        <div class="col-md-2">
            @lang('messages.ID')
        </div>
        <div class="col-md-10">
            {{ $object->id }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Title')
        </div>
        <div class="col-md-10">
            {{ $object->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Description')
        </div>
        <div class="col-md-10">
            {{ $object->description }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Path with namespace')
        </div>
        <div class="col-md-10">
            {{ $object->path_with_namespace }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            @lang('messages.Web url')
        </div>
        <div class="col-md-10">
            <a href="{{ $object->web_url }}">{{ $object->web_url }}</a>
        </div>
    </div>

@endsection

@section('details')
    @if (\Illuminate\Support\Facades\Auth::user()->hasPermissionTo(\App\User::PERMISSION_PROJECT_FINANCES))
        <table class="table dataTable">
            <thead>
            <tr>
                <th class="col-md-6">@lang('messages.Assignee')</th>
                <th class="col-md-3">@lang('messages.Hours')</th>
                <th class="col-md-3">@lang('messages.Amount')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contributorAmountList as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->hours }}</td>
                    <td>{{ $item->amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
