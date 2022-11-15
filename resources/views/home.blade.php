<?php
use App\User;
use Illuminate\Support\Facades\Auth;
?>
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
            'url' => route('project.index'),
        ])

        @include('partial/count_widget', [
            'color' => 'purple',
            'icon'  => 'fa fa-flag',
            'title' => __('messages.Milestones'),
            'count' => $milestones,
            'url' => route('milestone.index'),
        ])

        @include('partial/count_widget', [
            'color' => 'red',
            'icon'  => 'fa fa-tasks',
            'title' => __('messages.Issues'),
            'count' => $issues,
            'url' => route('issue.index'),
        ])

        @include('partial/count_widget', [
            'color' => 'teal',
            'icon'  => 'fa fa-comment',
            'title' => __('messages.Comments'),
            'count' => $notes,
            'url' => route('note.index'),
        ])

        @include('partial/count_widget', [
            'color' => 'yellow',
            'icon'  => 'fa fa-clock',
            'title' => __('messages.Spent time'),
            'count' => $spent,
            'url' => route('time.index'),
        ])

        @include('partial/count_widget', [
            'color' => 'silver',
            'icon'  => 'ion ion-person',
            'title' => __('messages.Active users'),
            'count' => $user,
            'url' => route('user.index'),
        ])

        @include('partial/count_widget', [
            'color' => $myBalance >= 0 ? 'green' : 'red',
            'icon'  => 'fa fa-hourglass' . ($myBalance == 0 ? '-half' : ($myBalance < 0 ? '-end' : '')),
            'title' => __('messages.My balance'),
            'hint' => __('messages.Payed hours minus spent hours'),
            'count' => $myBalance,
            'url' => route('time.index', ['authors' => [Auth::user()->contributor_id]]),
            'bgColor' => $myBalance >= 0 ? 'green' : 'red',
        ])

        @if (Auth::user()->hasPermissionTo(User::PERMISSION_SHOW_PAYMENTS))
            @include('partial/count_widget', [
                'color' => $companyBalance >= 0 ? 'green' : 'red',
                'icon'  => 'fa fa-hourglass' . ($companyBalance == 0 ? '-half' : ($companyBalance < 0 ? '-end' : '')),
                'title' => __('messages.Company balance'),
                'hint' => __('messages.Payed hours minus spent hours'),
                'count' => $companyBalance,
                'url' => route('contributor.index'),
                'bgColor' => $companyBalance >= 0 ? 'green' : 'red',
            ])
        @endif
    </div>
@stop
