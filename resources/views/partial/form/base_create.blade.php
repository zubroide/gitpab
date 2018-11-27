<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        @section('errorMessage')
            @if (!empty($errorMessage)):
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> @lang('messages.Error')</h4>
                    {{ $errorMessage }}
                    <?php var_dump($errors) ?>
                </div>
            @endif
        @show

        <!-- general form elements -->
        <div class="box box-primary">

            @section('formTag')
            @show

            <div class="box-body">
                @section('form')
                @show
            </div>

            <div class="box-footer">
                @section('formButtons')
                @show
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>