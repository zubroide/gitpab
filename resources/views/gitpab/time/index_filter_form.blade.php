@extends('partial.form.base_filter')
@section('formBody')
    {!! Form::open(array('url' => route('time.index'), 'method' => 'get')) !!}
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                @include('partial.form.element.text', [
                    'name' => 'id',
                    'value' => $request->input('id'),
                    'label' => 'ID',
                ])
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                @include('partial.form.element.text', [
                    'name' => 'issue_iid',
                    'value' => $request->input('issue_iid'),
                    'label' => 'Issue number',
                ])
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                @include('partial.form.element.select', [
                    'name' => 'authors[]',
                    'list' => $authorsList,
                    'selected' => $request->input('authors'),
                    'options' => ['multiple' => 'multiple'],
                    'label' => 'Authors',
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
                    'label' => 'Projects',
                ])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <span class="group-btn">
                    <button name="submit" value="1" type="submit" class="btn btn-primary">Применить</button>
                </span>
                <span class="group-btn">
                    <a class="btn btn-default" href="{{ route('time.index') }}">Сбросить</a>
                </span>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection