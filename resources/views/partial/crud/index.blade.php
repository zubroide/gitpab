@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @section('contentMessage')
                @if ($request->session()->has('message')):
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success</h4>
                    {{ $request->session()->get('message') }}
                </div>
                @endif
            @show

            <div class="box">
                <div class="box-header">
                    @section('contentTableControl')
                        @if (empty($__env->yieldContent('contentTableControl')))
                            @include('partial.form.base_control')
                        @endif
                    @show
                    <div class="box-tools">
                        {{ sizeof($itemsList) }} of {{ $itemsList->total() }}
                    </div>
                </div>

                @section('contentTableFilter')
                        <!-- Filter Form -->
                @show

                <div class="box-body table-responsive no-padding">
                    @section('contentTable')
                        @if (empty($__env->yieldContent('contentTable')))
                            @include('partial.crud.index_table')
                        @endif
                    @show
                </div>

                <div class="box-footer clearfix">
                    {!! $itemsList->appends(array_merge($request->old(), $request->input()))->render() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.crud_destroy_btn_js').ajaxActionHelper({
                type: 'DELETE'
            });
        });
        $(document).ready(function () {
            $('.crud_restore_btn_js').ajaxActionHelper({
                type: 'PUT'
            });
        });
    </script>
@append<!-- ./wrapper -->