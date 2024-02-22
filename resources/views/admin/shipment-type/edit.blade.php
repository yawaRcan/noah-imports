<form class="form-horizontal" id="shiptype-edit-form"  action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{$ShipmentType->name}}" placeholder="Write Shipment Type">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="shiptype-edit-button" data-shiptype-id="{{$ShipmentType->id}}">Edit</button>
    </div>
</form>