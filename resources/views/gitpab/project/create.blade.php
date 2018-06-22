@extends('partial.crud.create', ['pageTitle' => 'Create Project'])

@section('form')

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'id',
                    'label' => 'ID',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'name',
                    'label' => 'Name',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'description',
                    'label' => 'Description',
                    'isRequired' => false,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'path_with_namespace',
                    'label' => 'Path With Namespace',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'namespace_id',
                    'label' => 'namespace_id',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'web_url',
                    'label' => 'web_url',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'ssh_url_to_repo',
                    'label' => 'ssh_url_to_repo',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'http_url_to_repo',
                    'label' => 'http_url_to_repo',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! view('partial.form.element.text', [
                    'name' => 'creator_id',
                    'label' => 'creator_id',
                    'isRequired' => true,
                ])->render() !!}
            </div>
        </div>
    </div>

@endsection