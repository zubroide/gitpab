<script>
    $(document).ready(function () {
        var clickable = true;
        @if(isset($parent_id))
            clickable = false;
        @endif

        var uploadImagePanel = new UploadImagePanel({
            'entityField': "{{$entity_field}}",
            'entityFieldCamel': "{{camel_case($entity_field)}}",
            'entityTable': "{{$entity}}",
            'entityId': "{{$entity_id}}",
            'staticHost': "<?php echo config('app.img.app_statichost_img')?>",
            'clickable': clickable,
        });
    })
</script>

<form action="/file-upload" class="dropzone" id="{{$entity_field}}" method="POST" style="width:300px; float:left; margin-right: 20px;">
    <p>{{$label}}</p>
    <input name="_method" type="hidden" value="PATCH">
    <div class="form-group" style="float: left;">
        @if(!isset($parent_id) || !$parent_id)<div class="dz-message btn btn-default">Загрузить картинку</div>@endif
        <div id="previews{{camel_case($entity_field)}}"></div>
        <input type="hidden" name="entity_table" value="{{$entity}}">
        <input type="hidden" name="entity_id" value="{{$entity_id}}">
        <input type="hidden" name="entity_fieldname" value="{{$entity_field}}">
    </div>
    <div id="images{{camel_case($entity_field)}}" @if(!isset($parent_id) || !$parent_id)style="margin-top:120px;"@else style="margin-top:30px;" @endif></div>
</form>

