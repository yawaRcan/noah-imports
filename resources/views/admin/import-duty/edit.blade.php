<form class="form-horizontal" id="impduty-edit-form" action="javascript:void(0)"> 
    @csrf  
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{$ImportDuty->name}}" placeholder="Write Import Name">
    </div>
    <div class="mb-3">
        <label>Value</label>
        <input type="text" class="form-control" name="value" value="{{$ImportDuty->value}}" placeholder="Write Import Value">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="impduty-edit-button" data-impduty-id="{{$ImportDuty->id}}">Edit</button>
    </div>
</form>