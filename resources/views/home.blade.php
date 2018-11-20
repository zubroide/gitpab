@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>@lang('messages.Dashboard')</h1>
@stop

@section('content')
    <div class="row">
        @include('partial/count_widget', [
            'color' => 'aqua',
            'icon'  => 'ion ion-ios-gear',
            'title' => __('messages.Projects'),
            'count' => $projects,
        ])

        @include('partial/count_widget', [
            'color' => 'purple',
            'icon'  => 'fa fa-flag',
            'title' => __('messages.Milestones'),
            'count' => $milestones,
        ])

        @include('partial/count_widget', [
            'color' => 'red',
            'icon'  => 'fa fa-tasks',
            'title' => __('messages.Issues'),
            'count' => $issues,
        ])

        @include('partial/count_widget', [
            'color' => 'green',
            'icon'  => 'fa fa-comment',
            'title' => __('messages.Comments'),
            'count' => $notes,
        ])

        @include('partial/count_widget', [
            'color' => 'yellow',
            'icon'  => 'fa fa-clock-o',
            'title' => __('messages.Spent time'),
            'count' => $spent,
        ])
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
