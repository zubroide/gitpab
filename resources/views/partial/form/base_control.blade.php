<!-- form start -->
@section('controlFormBody')
    @if (isset($createRoute) && !empty($createRoute))
        <a
                class="btn btn-success js_link"
                href="{{ route($createRoute) }}?back_url={{ urlencode(Request::fullUrl()) }}">
            Create
        </a>
    @endif
@show
