<form class="form-horizontal" id="payment-add-form"  action="javascript:void(0)" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="" placeholder="Write Payment Mode">
    </div>
    <div class="mb-3">
        <label>Icon</label>
        <input type="file" id="nl-exship-add-file" class="form-control" name="icon" value="">
    </div>
    <div class="mb-3">
        <label>Information</label>
        <input type="hidden" id="quill_html" name="information"></input>
        <div id="information" style="height: 300px;">
        </div>
    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="payment-add-button">Add</button>
    </div>
</form>
<script type="text/javascript">

    var quill = new Quill('#information', {
            theme: 'snow'
    });
   quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("quill_html").value = quill.root.innerHTML;
    });

   $("#nl-exship-add-file").change(function () {
    filePreview(this);
});
    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.nl-exship-file-add-preview').remove();
                if (input.files[0].type.indexOf('image') === 0) {
                      // If it's an image, display it in the file preview
                      $('#ni-add-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-file-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                    } else {
                      // If it's not an image, display the document icon
                      $('#ni-add-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-file-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                    }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
   
</script>