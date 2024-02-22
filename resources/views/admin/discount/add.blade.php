<form class="form-horizontal" id="discount-add-form"  action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Select User</label>
        <select class="form-control" name="user_id" id="">
            @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <input type="text" class="form-control" name="description" value="" placeholder="Write Discount Description">
    </div>
    <div class="mb-3">
        <label>Value</label>
        <input type="text" class="form-control" name="value" value="" placeholder="Write Discount Value">
    </div>
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="discount-add-button">Add</button>
    </div>
</form>