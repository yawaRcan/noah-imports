<form class="form-horizontal" id="category-add-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Category Title</label>
        <input type="text" class="form-control" name="title" value="" placeholder="Write category title">
    </div>
    <div class="mb-3">
        <label>Category Summary</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <span class="mdi mdi-sort-descending"></span>
            </span>
            <textarea class="form-control" name="category_sum" id="ni-category-sum"></textarea>
        </div>
    </div>
    <div class="col-md-12">
        <label>Upload Category Photo</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <span class="mdi mdi-file-image"></span>
            </span>
            <input type="file" class="form-control" name="category_file" id="ni-category-file">
        </div>
    </div>
    <div class="col-12" id="ni-category-file-append">

    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="category-add-button">Add</button>
    </div>
</form>

<script>
        $("#ni-category-file").change(function() {
        filePreview(this);
    });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-exship-category-add-preview').remove();
                if (input.files[0].type.indexOf('image') === 0) {
                  // If it's an image, display it in the file preview
                  $('#ni-category-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-category-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                } else {
                  // If it's not an image, display the document icon
                  $('#ni-category-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-category-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>