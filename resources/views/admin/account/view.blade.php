@extends('admin.layout.master')

@section('content')
@push('head-script')
<link href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
@endpush
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Edit Account</h4>
                        </div>
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col-md-8">
                        <form class="form-horizontal" action="javascript:void(0)" id="account-update-form">
                            @csrf
                            <label for="tb-rfname">First Name</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-user"></span>
                                <input id="first_name" class="form-control" type="text" name="first_name" value="{{$user->first_name}}" required autofocus autocomplete="first_name" />
                            </div>
                            <label for="tb-rfname">Last Name</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-user"></span>
                                <input id="last_name" class="form-control" type="text" name="last_name" value="{{$user->last_name}}" required autofocus autocomplete="last_name" />
                            </div>
                            <label for="tb-rfname">Username</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-user"></span>
                                <input id="name" class="form-control" type="text" name="username" value="{{$user->username}}" required autofocus autocomplete="username" readonly />
                            </div>
                            <label for="tb-remail">Email</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-envelope"></span>
                                <input class="form-control" id="email" type="email" name="email" value="{{$user->email}}" required autocomplete="email" readonly />
                            </div>
                            <label for="tb-remail">Gender</label>
                            <div class="input-group mb-3">
                              <span class="input-group-text fa fa-user"></span>
                              <select class="form-control" name="gender">
                                  <option value="">Select Gender</option>
                                  <option value="0" {{$user->gender == 0 ? 'selected': ''}}>Male</option>
                                  <option value="1" {{$user->gender == 1 ? 'selected': ''}}>Female</option>
                              </select>
                            </div>
                            <label for="tb-remail">Date of Birth</label>
                            <div class="input-group mb-3">
                              <span class="input-group-text fa fa-user"></span>
                              <input class="form-control" id="dob" type="date" name="dob" value="{{$user->dob}}" required autocomplete="dob" />
                            </div>
                            <label for="tb-remail">Phone</label>
                            <div class="valid-msg-wrap">
                                 <span id="valid-msg" class="hide">✓ Valid</span>
                                 <span id="error-msg" class="hide">Invalid number</span>
                             </div>
                            <div class="form-group mb-3">
                                <input class="form-control form-control-prepended" id="contact_no" type="tel" value="{{$user->phone}}" />
                            </div>
                            <input type="hidden" name="formType" value="account">
                            <input type="hidden" name="initial_country" id="initial_country" value="{{$user->initial_country}}">
                            <input type="hidden" name="country_code" id="country_code" value="{{$user->country_code}}">
                            <input type="hidden" name="phone" id="phone_complete" value="{{$user->phone}}">
                            <label for="tb-remail">Country</label>
                            <div class="input-group mb-3">
                              <!-- <span class="input-group-text fa fa-flag"></span> -->
                              <select class="form-control select2" name="country_id" required>
                                  @foreach($countries as $key => $name)
                                     <option value="{{$key}}" {{$user->country_id == $key ? 'selected' : ''}}>{{$name}}</option>
                                  @endforeach
                              </select>
                            </div>
                            <div class="d-flex align-items-stretch">
                                <button type="button" data-account-id="{{$user->id}}" id="account-update-btn" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="list-group">
                          <a href="{{route('account.index')}}" class="list-group-item list-group-item-action active">
                            Edit Account
                          </a>
                          <a href="{{route('account.profile.view')}}" class="list-group-item list-group-item-action">Account Privacy</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')

<script src="{{asset('assets/extra-libs/input-tel/js/intlTelInput.min.js')}}"></script>
 <script>
    $( document ).ready(function() {
       $('.select2').select2();

        var countryCode = 'us';
     var inputJquery = document.querySelector("#contact_no"); 
     
     var contact = intlTelInput(inputJquery, {
         autoHideDialCode: true,
         allowDropdown: true,
         autoInsertDialCode: true,
         autoPlaceholder: "aggressive",
         customPlaceholder: null,
         dropdownContainer: null,
         excludeCountries: [],
         formatOnDisplay: true,
         initialCountry: "{{$user->initial_country}}",
         geoIpLookup: function(callback) {
             $.get('https://ipinfo.io', function() {}, "json").always(function(resp) { 
                  countryCode = (resp && resp.country) ? resp.country : "us";
                 callback(countryCode);
             });
         },
         hiddenInput: "", 
         localizedCountries: null,
         nationalMode: true,
         onlyCountries: [],
         placeholderNumberType: "MOBILE",
         preferredCountries: ['cw', 'us', 'gb'],
         separateDialCode: true,
         showFlags: true,
         utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/js/utils.js?1613236686837"
     });

     isValid(inputJquery); //init is valid

     //Check if number is valid
     function isValid(inputSelect) {

         var input, iti_IsValid, iti_Error, reset, errorMap, errorMsg, validMsg;

         input = inputSelect;

         errorMsg = document.querySelector("#error-msg"),
         validMsg = document.querySelector("#valid-msg");

         // here, the index maps to the error code returned from getValidationError - see readme
         errorMap = ['INVALID NO', "Invalid country code", 'TOO SHORT', 'TOO LONG', 'NULL'];

         reset = function() {
             input.classList.remove("error");
             errorMsg.innerHTML = "";
             errorMsg.classList.add("hide");
             validMsg.classList.add("hide");
         };

         // on blur: validate
         input.addEventListener('blur', function() {
             reset(); 
             if (input.value.trim()) {

                 iti_IsValid = contact.isValidNumber();
                 iti_Error = contact.getValidationError();
                     console.log(iti_IsValid,iti_Error)
                 if (iti_IsValid && iti_IsValid !== null) {
                     getFullData(this)
                     validMsg.classList.remove("hide");
                 } else {
                    $('#isvalid').val(contact.isValidNumber());
                     input.classList.add("error");
                     var errorCode = iti_Error;

                     if (iti_IsValid == null || errorCode == -99) {
                         errorCode = 0;
                     }

                     errorMsg.innerHTML = errorMap[errorCode];
                     errorMsg.classList.remove("hide");
                 }
             }
         });

         // on keyup / change flag: reset
         input.addEventListener('change', reset);
         input.addEventListener('keyup', reset);
     }

    

     //Get country data
     function getFullData(input) {
         var code, phone, name, country_code, isvalid;
         code = contact.getSelectedCountryData().dialCode;
         phone = $('#contact_no').val();
         name = contact.getSelectedCountryData().name;
         country_code = contact.getSelectedCountryData().iso2;
         isvalid = contact.isValidNumber();
         $('#phone_complete').val(phone);
         $('#country_code').val(code);
         $('#initial_country').val(country_code);
         $('#isvalid').val(isvalid);
         console.log(code,phone,name,country_code,isvalid)
         return {
             'code': code,
             'phone': phone,
             'name': name,
             'country_code': country_code,
             'valid': isvalid
         };
     }

    });

    $(document).on('click', "#account-update-btn", function() {

        let id = $(this).data("account-id");
        let url = "{{route('account.update', ['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#account-update-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, null, null)

    })
</script>
@endpush