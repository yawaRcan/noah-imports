<form class="form-horizontal" id="coupon-add-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Coupon Code</label>
        <input type="text" class="form-control" name="code" value="" placeholder="Write coupon code">
    </div>  
    <div class="mb-3">
        <label>Coupon Value</label>
        <input type="nmber" class="form-control" name="value" value="" placeholder="Write coupon value">
    </div> 
    <div class="mb-3">
        <label>Coupon Type</label>
        <select name="type" class="form-control" id="type">
            <option value="">Select Type</option>
            <option value="fixed">Fixed</option>
            <option value="percent">Percentage</option>
        </select>
    </div> 
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="coupon-add-button">Add Coupon</button>
    </div>
</form>  