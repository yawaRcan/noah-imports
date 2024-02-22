<form class="form-horizontal" id="branch-edit-form" action="javascript:void(0)">
    @csrf
    <div class="mb-3">
        <label>First Name</label>
        <input type="text" class="form-control" name="name" value="{{$Branch->name}}" placeholder="Write Branch First Name">
    </div>
    <div class="mb-3">
         <label>Last Name</label>
         <input type="text" class="form-control" name="last_name" value="{{$Branch->last_name}}" placeholder="Write Branch Last Name">
     </div>
    <div class="mb-3">
        <label>Email Address</label>
        <input type="text" class="form-control" name="email" value="{{$Branch->email}}" placeholder="Write Email Address">
    </div>
    <div class="mb-3">
        <label>Branch Address</label>
        <input type="text" class="form-control" name="address" value="{{$Branch->address}}" placeholder="Write Branch Address">
    </div>
    <div class="row">
         <div class="col-md-6">
             <div class="mb-3">
                <label class="mr-5">Phone Number</label>
                <div class="valid-msg-wrap">
                    <span id="valid-msg" class="hide">✓ Valid</span>
                    <span id="error-msg" class="hide">Invalid number</span>
                </div>
                <input type="tel" id="contact_no" name="contact_no" class="form-control w-100"  value="{{$Branch->phone}}" >
            </div>
         </div>
         <div class="col-md-6">
             <div class="mb-3">
                 <label>Zipcode</label>
                 <input type="text" class="form-control" name="zipcode" value="{{$Branch->zipcode}}" placeholder="Write Zipcode">
             </div>
         </div>
     </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="mr-5">Country</label>
                <select name="country" id="ni-edit-country" class="country-select form-control custom-select" style="width: 90%;">
                    @foreach($countries as $key => $val)
                        <option value="{{$key}}" {{$Branch->country_id == $key ? 'selected': ''}}>{{$val}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>State</label>
                <input type="text" class="form-control" name="state" value="{{$Branch->state}}" placeholder="Write State">
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-6">
             <div class="mb-3">
                 <label class="mr-5">Address Line2</label>
                 <input type="text" class="form-control" name="address_line" value="{{$Branch->address_line}}" placeholder="Address Line 2">
             </div>
         </div>
         <div class="col-md-6">
             <div class="mb-3">
                 <label>City</label>
                 <input type="text" class="form-control" name="city" value="{{$Branch->city}}" placeholder="Write City">
             </div>
         </div>
     </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>Currency</label>
                <select name="currency_id" class="form-control">
                    <option value="">Select Currency</option>
                    @foreach($currency as $curr)
                    <option value="{{$curr->id}}" {{$Branch->currency_id == $curr->id ? 'selected': ''}}>{{$curr->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Pickup Fee</label>
                <input type="text" class="form-control" name="pickup_fee" value="{{$Branch->pickup_fee}}" placeholder="Write Pickup Fee">
            </div>
        </div>
    </div>
    <input type="hidden" name="initial_country" id="initial_country" value="{{$Branch->initial_country}}">
    <input type="hidden" name="country_code" id="country_code" value="{{$Branch->country_code}}">
    <input type="hidden" name="phone_complete" id="phone_complete" value="{{$Branch->phone}}">
    <input type="hidden" name="isvalid" id="isvalid">
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="branch-edit-button" data-branch-id="{{$Branch->id}}">Edit</button>
    </div>
</form>
<script src="{{asset('assets/extra-libs/input-tel/js/intlTelInput.min.js')}}"></script>
 <script>
    $( document ).ready(function() {

        var countryIdToCodeMap = {!! json_encode($countryCodes) !!};

     $('.country-select').select2({
      templateResult: formatCountryOption,
      templateSelection: formatCountryOption,
    });

     function formatCountryOption(country) {
        if (!country.id) {
          return country.text;
        }

        var countryCode = countryIdToCodeMap[country.id].toLowerCase();
        var countryName = country.text;
        return $(
          '<span><i class="flag-icon flag-icon-' + countryCode + ' flag-icon-squared"></i> ' + countryName + '</span>'
        );
      }

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
         initialCountry: "{{$Branch->initial_country}}",
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
 </script>