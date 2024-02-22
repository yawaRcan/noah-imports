<form class="form-horizontal" id="user-edit-form" action="javascript:void(0)"> 
    @csrf 
    <div class="mb-3">
        <label>First name</label>
        <input type="text" class="form-control" name="first_name" value="{{$User->first_name}}" readonly>
    </div>
    <div class="mb-3">
        <label>Last name</label>
        <input type="text" class="form-control" name="last_name" value="{{$User->last_name}}" readonly>
    </div>
    <div class="mb-3">
        <label>Username</label>
        <input type="text" class="form-control" name="username" value="{{$User->username}}" readonly>
    </div>
    <div class="mb-3">
        <label>Company</label>
        <input type="text" class="form-control" name="company" value="{{$User->company}}" readonly>
    </div>
    <div class="mb-3">
        <label>Gender</label>
         <select name="gender" class="form-control" id="gender_id" disabled>
          <option value="">Select Gender</option>
          <option value="0" {{$User->gender == 0 ? 'selected': ''}}>Male</option>
          <option value="1" {{$User->gender == 1 ? 'selected': ''}}>Female</option>
      </select>
    </div>
    <div class="mb-3">
        <label>Country</label>
         <select name="country" class="form-control" id="country_id" disabled>
            <option value="">Select Country</option>
            @foreach($countries as $key => $name)
                 <option value="{{$key}}" {{$User->country_id == $key ? 'selected' : ''}}>{{$name}}</option>
            @endforeach
         </select>
    </div>
    <div class="mb-3">
        <label>Date of Birth</label>
        <input type="date" class="form-control" name="dob" value="{{$User->dob}}" readonly>
    </div>
    <div class="mb-3">
        <label>Phone Number</label>
        <input type="tel" class="form-control" id="contact_no" name="phone" value="{{$User->phone}}" readonly>
    </div>
    <div class="mb-3">
        <label>Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{$User->email}}" placeholder="Enter Email">
    </div>
    <div class="mb-3">
        <label>Status</label>
         <select name="status" class="form-control" id="status_id">
            <option value="1" {{$User->email_verified_at !== null ? 'selected': ''}}>Active</option>
            <option value="0" {{$User->email_verified_at == null ? 'selected': ''}}>In Active</option>
         </select>
    </div>
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="user-edit-button" data-user-id="{{$User->id}}">Update</button>
    </div>
</form>