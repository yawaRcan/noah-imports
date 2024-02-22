<form class="form-horizontal" id="payment-edit-form" action="javascript:void(0)"> 
    @csrf 
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{$Payment->name}}" placeholder="Write Payment Mode">
    </div>
    <div class="mb-3">
        <label>Icon</label>
        <input type="file" id="nl-exship-edit-file" class="form-control" name="icon" value="" placeholder="Upload Icon">
        @if(isset($Payment->icon))
        <div class="text-center p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset('storage/assets/icons')}}/{{$Payment->icon}}" width="450" height="300"/></div>
        @endif
    </div>
    <div class="mb-3">
        <label>Information</label>
        <input type="hidden" id="quill_html" value="{{$Payment->information}}" name="information"></input>
        <div id="information" style="height: 300px;">
            {!! $Payment->information !!}
        </div>
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="payment-edit-button" data-payment-id="{{$Payment->id}}">Edit</button>
    </div>
</form>

<script type="text/javascript">

    var quill = new Quill('#information', {
            theme: 'snow'
    });
   quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("quill_html").value = quill.root.innerHTML;
    });


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