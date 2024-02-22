<form class="form-horizontal" id="currency-edit-form" action="javascript:void(0)"> 
    @csrf  
    <div class="mb-3">
        <label>Currency Name</label>
        <input type="text" class="form-control" name="name" value="{{$Currency->name}}" placeholder="Write Name">
    </div>
    <div class="mb-3">
        <label>Currency Code</label>
        <input type="text" class="form-control" name="code" value="{{$Currency->code}}" placeholder="Write Currency Code">
    </div>
    <div class="mb-3">
        <label>Currency Symbol</label>
        <input type="text" class="form-control" name="symbol" value="{{$Currency->symbol}}" placeholder="Write Currency Symbol">
    </div>
    <div class="mb-3">
        <label>Currency Value</label>
        <input type="text" class="form-control" name="value" value="{{$Currency->value}}" placeholder="Write Currency Value">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="currency-edit-button" data-currency-id="{{$Currency->id}}">Edit</button>
    </div>
</form>