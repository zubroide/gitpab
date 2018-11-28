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
            'route' => 'project.index',
        ])

        @include('partial/count_widget', [
            'color' => 'purple',
            'icon'  => 'fa fa-flag',
            'title' => __('messages.Milestones'),
            'count' => $milestones,
            'route' => 'milestone.index',
        ])

        @include('partial/count_widget', [
            'color' => 'red',
            'icon'  => 'fa fa-tasks',
            'title' => __('messages.Issues'),
            'count' => $issues,
            'route' => 'issue.index',
        ])

        @include('partial/count_widget', [
            'color' => 'teal',
            'icon'  => 'fa fa-comment',
            'title' => __('messages.Comments'),
            'count' => $notes,
            'route' => 'note.index',
        ])

        @include('partial/count_widget', [
            'color' => 'yellow',
            'icon'  => 'fa fa-clock-o',
            'title' => __('messages.Spent time'),
            'count' => $spent,
            'route' => 'time.index',
        ])

        @include('partial/count_widget', [
            'color' => 'silver',
            'icon'  => 'ion ion-person',
            'title' => __('messages.Active users'),
            'count' => $user,
            'route' => 'user.index',
        ])
    </div>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
