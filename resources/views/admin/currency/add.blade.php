<form class="form-horizontal" id="currency-add-form"  action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Currency Name</label>
        <input type="text" class="form-control" name="name" value="" placeholder="Write Name">
    </div>
    <div class="mb-3">
        <label>Currency Code</label>
        <input type="text" class="form-control" name="code" value="" placeholder="Write Currency Code">
    </div>
    <div class="mb-3">
        <label>Currency Symbol</label>
        <input type="text" class="form-control" name="symbol" value="" placeholder="Write Currency Symbol">
    </div>
    <div class="mb-3">
        <label>Currency Value</label>
        <input type="text" class="form-control" name="value" value="" placeholder="Write Currency Value">
    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="currency-add-button">Add</button>
    </div>
</form>