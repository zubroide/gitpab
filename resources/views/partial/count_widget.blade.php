<div class="col-md-3 col-sm-6 col-xs-12">
    <a href="{{ route($route) }}" class="info-box-url">
        <div class="info-box {{ isset($bgColor) ? 'bg-' . $bgColor : '' }}">
            <span class="info-box-icon {{ isset($bgColor) ? '' : 'bg-' . $color }}"><i class="{{ $icon }}"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{ $title }}</span>
                <span class="info-box-number">{{ $count }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <!-- /.info-box -->
</div>
