<form class="form-horizontal" id="brand-edit-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>Brand Title</label>
        <input type="text" class="form-control" name="title" value="{{$Brand->title}}" placeholder="Write brand title">
    </div>  
    <div class=" text-end">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="brand-edit-button" data-brand-id="{{$Brand->id}}">Add</button>
    </div>
</form> 