<form class="form-horizontal" id="exship-edit-form"  action="javascript:void(0)" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{$ExternalShipper->name}}" placeholder="Write Shipment Mode">
    </div> 
    <div class="mb-3">
        <label>Icon</label>
        <input type="file" id="nl-exship-edit-file" class="form-control" name="icon" value="" placeholder="Upload Icon">
        @if(isset($ExternalShipper->icon))
        <div class="text-center p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset('storage/assets/icons')}}/{{$ExternalShipper->icon}}" width="450" height="300"/></div>
        @endif
    </div>
    <div class="mb-3">
        <label>Link</label>
        <input type="text" class="form-control" name="link" value="{{$ExternalShipper->link}}" placeholder="Past Link">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="exship-edit-button" data-exship-id="{{$ExternalShipper->id}}">Edit</button>
    </div>
</form>

<script>

$("#nl-exship-edit-file").change(function () { 
    filePreview(this);
});
    function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.nl-exship-file-edit-preview').remove();
            if (input.files[0].type.indexOf('image') === 0) {
              // If it's an image, display it in the file preview
              $('#ni-edit-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-file-edit-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
            } else {
              // If it's not an image, display the document icon
              $('#ni-edit-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>