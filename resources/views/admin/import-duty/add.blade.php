<form class="form-horizontal" id="impduty-add-form"  action="javascript:void(0)">
    @csrf 
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="" placeholder="Write Import Name">
    </div>
    <div class="mb-3">
        <label>Value</label>
        <input type="text" class="form-control" name="value" value="" placeholder="Write Import Value">
    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="impduty-add-button">Add</button>
    </div>
</form>