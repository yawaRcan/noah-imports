<form class="form-horizontal" id="shipmode-edit-form" action="javascript:void(0)"> 
    @csrf 
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{$shipMentMode->name}}" placeholder="Write Shipment Mode">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="shipmode-edit-button" data-shipmode-id="{{$shipMentMode->id}}">Edit</button>
    </div>
</form>