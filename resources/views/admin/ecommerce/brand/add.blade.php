<form class="form-horizontal" id="brand-add-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Brand Title</label>
        <input type="text" class="form-control" name="title" value="" placeholder="Write category title">
    </div>  
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="brand-add-button">Add</button>
    </div>
</form> 