<form class="form-horizontal" method="POST" id="ni-reciever-address-add-form" action="javascript:void(0)">
    @csrf
    <input type="hidden" id="ni-reciever-user" name="reciever_user_id">
    <label for="tb-rfname">First Name</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text fa fa-user"></span>
        </div>
        <input id="first_name" value="{{$user->first_name}}" class="form-control" type="text" name="first_name" autofocus autocomplete="first_name" />

    </div>
    <label for="tb-rfname">Last Name</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text fa fa-user"></span>
        </div>
        <input id="last_name" value="{{$user->last_name}}" class="form-control" type="text" name="last_name" autocomplete="last_name" />

    </div>

    <label for="tb-remail">Email</label>
    <div class="input-group mb-3">
        <span class="input-group-text fa fa-envelope"></span>
        <input class="form-control" value="{{$user->email}}" id="email" type="email" name="email" :value="old('email')" autocomplete="email" />
    </div>

    <label for="tb-remail">Phone</label>
    <div class="valid-msg-wrap">
         <span id="valid-msg" class="hide">✓ Valid</span>
         <span id="error-msg" class="hide">Invalid number</span>
     </div>
    <div class="input-group mb-3">
        <span class="input-group-text mdi mdi-phone"></span>
        <input class="form-control form-control-prepended"  name="contact_no" id="contact_no" type="tel" />
    </div>

    <input type="hidden" name="initial_country" id="initial_country">
    <input type="hidden" name="country_code" id="country_code">
    <input type="hidden" name="phone" id="phone_complete">
    <label for="tb-remail">Address</label>
    <div class="input-group mb-3">
        <span class="input-group-text fa fa-address-card"></span>
        <input class="form-control" id="address" type="text" name="address" :value="old('address')" autocomplete="address" />
    </div>

    <label for="tb-remail">Country</label>
    <div class="input-group mb-3">
        <span class="input-group-text fa fa-flag"></span>
        <select class="select2 form-control" name="country_id" style="width: 90%;">
        <option>-- Select Country --</option>
          @foreach($countries as $key => $name)
             <option value="{{$key}}" <?php echo ($key==$user->country_id) ?'selected':'' ?>>{{$name}}</option>
          @endforeach
      </select>
    </div>

    <label for="tb-remail">State</label>
    <div class="input-group mb-3">
        <span class="input-group-text fa fa-flag"></span>
        <input class="form-control" id="state" type="text" name="state" :value="old('state')" autocomplete="state" />
    </div>

    <label for="tb-remail">City</label>
    <div class="input-group mb-3">
        <span class="input-group-text mdi mdi-city"></span>
        <input class="form-control" id="city" type="text" name="city" :value="old('city')" autocomplete="city" />
    </div>

    <label for="tb-remail">ZipCode</label>
    <div class="input-group mb-3">
        <span class="input-group-text mdi mdi-code-string"></span>
        <input class="form-control" id="zipcode" type="text" name="zipcode" :value="old('zipcode')" autocomplete="zipcode" />
    </div>
    <label for="tb-remail">CRIB</label>
    <div class="input-group mb-3">
        <span class="input-group-text mdi mdi-code-equal"></span>
        <input class="form-control" id="crib" type="text" name="crib" :value="old('crib')" autocomplete="crib" />
    </div>
    <div class="d-flex align-items-stretch">
        <button type="button" class="btn btn-success"  id="ni-reciever-address-add-btn">Save</button>
    </div>
</form>

<script>
     var inputJquery = document.querySelector("#contact_no");

     var iti = intlTelInput(inputJquery, {
         utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/js/utils.js"
     });
     var contact = intlTelInput(inputJquery, {
         autoHideDialCode: true,
         allowDropdown: true,
         autoInsertDialCode: true,
         hiddenInput: "full_number",
         autoPlaceholder: "polite",
         customPlaceholder: null,
         dropdownContainer: null,
         excludeCountries: [],
         formatOnDisplay: true,
         initialCountry: "auto",
         geoIpLookup: function(callback) {
             $.get('https://ipinfo.io', function() {}, "json").always(function(resp) {
                 var countryCode = (resp && resp.country) ? resp.country : "us";
                 callback(countryCode);
             });
         },
         hiddenInput: "",
         initialCountry: "auto",
         localizedCountries: null,
         nationalMode: true,
         onlyCountries: [],
         placeholderNumberType: "MOBILE",
         preferredCountries: ['cw', 'us', 'gb'],
         separateDialCode: false,
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
             console.log(this)
             if (input.value.trim()) {

                 iti_IsValid = iti.isValidNumber();
                 iti_Error = iti.getValidationError();

                 if (iti_IsValid && iti_IsValid !== null) {
                    getFullData(this)
                     validMsg.classList.remove("hide");
                 } else {
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
         code = iti.getSelectedCountryData().dialCode;
         phone = $('#contact_no').val(); 
         name = iti.getSelectedCountryData().name;
         country_code = iti.getSelectedCountryData().iso2;
         isvalid = iti.isValidNumber();
         $('#phone_complete').val(phone);
        $('#country_code').val(code);
        $('#initial_country').val(country_code);
        $('#isvalid').val(isvalid);
         return {
             'code': code,
             'phone': phone,
             'name': name,
             'country_code': country_code,
             'valid': isvalid
         };
     } 
 </script>