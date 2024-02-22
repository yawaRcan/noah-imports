<form class="form-horizontal" id="rate-add-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Branch</label>
        <select name="branch_id" class="form-control">
            <option value="">Select Branch</option>
            @foreach($branch as $bran)
            <option value="{{$bran->id}}">{{$bran->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>LB</label>
        <input type="text" class="form-control" name="kg" value="" placeholder="Write LB">
    </div>
    <div class="mb-3">
        <label>Amount</label>
        <input type="text" class="form-control" name="amount" value="" placeholder="Write Amount">
    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="rate-add-button">Add</button>
    </div>
</form>