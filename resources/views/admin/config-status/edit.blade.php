<form class="form-horizontal" id="constatus-edit-form"  action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{$ConfigStatus->name}}" placeholder="Write Status Name">
    </div>
    <div class="mb-3">
        <label>Value</label>
        <input type="text" class="form-control" name="value" value="{{$ConfigStatus->value}}" placeholder="Write Status Value">
    </div>
    <div class="mb-3">
        <label>Color</label>
        <input type="color" class="form-control" name="color" value="{{$ConfigStatus->color}}" placeholder="Write Status Color">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="constatus-edit-button" data-constatus-id="{{$ConfigStatus->id}}">Edit</button>
    </div>
</form>