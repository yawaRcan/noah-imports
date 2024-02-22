<form class="form-horizontal" id="discount-edit-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Select User</label>
        <select class="form-control" name="user_id" id="">
            @foreach($users as $user)
            @if($user->id == $Discount->user_id)
            <option value="{{$user->id}}" selected>{{$user->name}}</option>
            @else
            <option value="{{$user->id}}">{{$user->name}}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <input type="text" class="form-control" name="description" value="{{$Discount->description}}" placeholder="Write Discount Description">
    </div>
    <div class="mb-3">
        <label>Value</label>
        <input type="text" class="form-control" name="value" value="{{$Discount->value}}" placeholder="Write Discount Value">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="discount-edit-button" data-discount-id="{{$Discount->id}}">Edit</button>
    </div>
</form>