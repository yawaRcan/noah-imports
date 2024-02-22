<form class="form-horizontal" id="rate-edit-form" action="javascript:void(0)"> 
    @csrf 
    <div class="mb-3">
        <label>Branch</label>
        <select name="branch_id" class="form-control">
            <option value="">Select Branch</option>
            @foreach($branch as $bran)
            @if($Rate->branch_id == $bran->id)
            <option value="{{$bran->id}}" selected>{{$bran->name}}</option>
            @else
            <option value="{{$bran->id}}">{{$bran->name}}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>LB</label>
        <input type="text" class="form-control" name="kg" value="{{$Rate->kg}}" placeholder="Write LB">
    </div>
    <div class="mb-3">
        <label>Amount</label>
        <input type="text" class="form-control" name="amount" value="{{$Rate->amount}}" placeholder="Write Amount">
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="rate-edit-button" data-rate-id="{{$Rate->id}}">Edit</button>
    </div>
</form>