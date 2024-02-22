@extends('admin.layout.master')

@section('content')
@push('head-script')
<link href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
@endpush
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Shipping Adresses</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Address</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>THIS MONTH</small></h6>
                    <h4 class="mt-0 text-info">ƒ {{$cm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>LAST MONTH</small></h6>
                    <h4 class="mt-0 text-primary">ƒ {{$lm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                            <h4 class="card-title mb-0">Add Shipping Adresses</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="javascript:void(0)" id="shipping-add-form">
                        @csrf
                        <label for="tb-rfname">First Name</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-user"></span>
                            </div>
                            <input id="first_name" class="form-control" type="text" name="first_name" autofocus autocomplete="first_name" />

                        </div>
                        <label for="tb-rfname">Last Name</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-user"></span>
                            </div>
                            <input id="last_name" class="form-control" type="text" name="last_name" autocomplete="last_name" />

                        </div>

                        <label for="tb-remail">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-envelope"></span>
                            <input class="form-control" id="email" type="email" name="email" :value="old('email')" autocomplete="email" />
                        </div>

                        <label for="tb-remail">Phone</label>
                        <div class="valid-msg-wrap">
                             <span id="valid-msg" class="hide">✓ Valid</span>
                             <span id="error-msg" class="hide">Invalid number</span>
                         </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text mdi mdi-phone"></span>
                            <input class="form-control form-control-prepended" name="contact_no" id="contact_no" type="tel" />
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
                            <select class="country-select form-control" name="country_id" style="width: 90%;">
                            <option value="">-- Select Country --</option>
                              @foreach($countries as $key => $name)
                                 <option value="{{$key}}">{{$name}}</option>
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

                        <div class="d-flex align-items-stretch">
                            <button type="button" id="shipping-add-button" class="btn btn-success">Save</button>
                        </div>
                    </form>
                    
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
         initialCountry: "auto",
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

    $(document).on('click', "#shipping-add-button", function() {

        let url = "{{route('shipping-address.store')}}";
        let formId = "#shipping-add-form";
        let type = "POST";
        createFormAjax(url, type, formId, null,null)

    })
</script>
@endpush