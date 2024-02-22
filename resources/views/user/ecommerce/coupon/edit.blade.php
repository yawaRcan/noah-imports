<form class="form-horizontal" id="coupon-edit-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Coupon Code</label>
        <input type="text" class="form-control" name="code" value="{{$coupon->code}}" placeholder="Write coupon code">
    </div>  
    <div class="mb-3">
        <label>Coupon Value</label>
        <input type="nmber" class="form-control" name="value" value="{{$coupon->value}}" placeholder="Write coupon value">
    </div> 
    <div class="mb-3">
        <label>Coupon Type</label>
        <select name="type" class="form-control" id="type">
            <option value="">Select Type</option>
            <option value="fixed" @if($coupon->type == 'fixed') selected @endif >Fixed</option>
            <option value="percent" @if($coupon->type == 'percent') selected @endif >Percentage</option>
        </select>
    </div> 
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="coupon-edit-button" data-coupon-id="{{$coupon->id}}">Edit Coupon</button>
    </div>
</form>  