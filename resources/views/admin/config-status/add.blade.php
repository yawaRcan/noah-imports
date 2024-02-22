<form class="form-horizontal" id="constatus-add-form"  action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="" placeholder="Write Status Name">
    </div>
    <div class="mb-3">
        <label>Value</label>
        <input type="text" class="form-control" name="value" value="" placeholder="Write Status Value">
    </div>
    <div class="mb-3">
        <label>Color</label>  
        <input type="color" class="form-control" name="color" value="" placeholder="Write Status Color">
    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="constatus-add-button">Add</button>
    </div>
</form>