<form class="form-horizontal" id="shiptype-add-form"  action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="" placeholder="Write Shipment Type">
    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="shiptype-add-button">Add</button>
    </div>
</form>