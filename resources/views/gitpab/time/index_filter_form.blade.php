@extends('partial.form.base_filter')
@section('formBody')
    {!! Form::open(array('url' => route('time.index'), 'method' => 'get')) !!}
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                @include('partial.form.element.text', [
                    'name' => 'id',
                    'value' => $request->input('id'),
                    'label' => __('messages.ID'),
                ])
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                @include('partial.form.element.text', [
                    'name' => 'issue_iid',
                    'value' => $request->input('issue_iid'),
                    'label' => __('messages.Issue number'),
                ])
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @include('partial.form.element.select', [
                    'name' => 'authors[]',
                    'list' => $authorsList,
                    'selected' => $request->input('authors'),
                    'options' => ['multiple' => 'multiple'],
                    'label' => __('messages.Authors'),
                ])
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                @include('partial.form.element.select', [
                    'name' => 'projects[]',
                    'list' => $projectsList,
                    'selected' => $request->input('projects'),
                    'options' => ['multiple' => 'multiple'],
                    'label' => __('messages.Projects'),
                ])
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                @include('partial.form.element.date_range', [
                    'name' => 'date_range',
                    'input' => [
                        'date_start' => $request->get('date_start'),
                        'date_end' => $request->get('date_end'),
                    ],
                    'label' => __('messages.Created At'),
                ])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                @include('partial.form.element.select', [
                    'name' => 'labels[]',
                    'list' => $labelList,
                    'selected' => $request->input('labels'),
                    'options' => ['multiple' => 'multiple'],
                    'label' => __('messages.Labels'),
                ])
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @include('partial.form.element.select', [
                    'name' => 'milestones[]',
                    'list' => $milestoneList,
                    'selected' => $request->input('milestones'),
                    'options' => ['multiple' => 'multiple'],
                    'label' => __('messages.Milestones'),
                ])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <span class="group-btn">
                    <button name="submit" value="1" type="submit" class="btn btn-primary">@lang('messages.Apply')</button>
                </span>
                <span class="group-btn">
                    <button name="submit" value="csv" type="submit" class="btn btn-default">@lang('messages.Export CSV')</button>
                    <button name="submit" value="act_tnm.csv" type="submit" class="btn btn-default">@lang('messages.Act t&m CSV')</button>
                    <button name="submit" value="act_tnm_labels.csv" type="submit" class="btn btn-default">@lang('messages.Act t&m/labels CSV')</button>
                </span>
                <span class="group-btn pull-right">
                    <a class="btn btn-default" href="{{ route('time.index') }}">@lang('messages.Reset')</a>
                </span>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection