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
        <h3 class="text-themecolor mb-0">Pickup Stations</h3>
        <!-- <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Address</li>
        </ol> -->
    </div>
    <!-- <div class="col-md-7 col-12 align-self-center d-none d-md-block">
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
    </div> -->
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
                            <h4 class="card-title mb-0">Edit Pickup Station</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="javascript:void(0)" id="pickup-update-form">
                        @csrf
                        <label for="tb-rfname">Warehouse/Branch</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-map-marker"></span>
                              </div>
                              <select class="form-control" name="branch_id" id="branch" required>
                                    @foreach($branches as $key => $name)
                                        <option value="{{$key}}" {{$station->branch_id == $key ? 'selected' : ''}}>{{$name}}</option>
                                    @endforeach
                              </select>
                        </div>
                        <label for="tb-rfname">Pickup Station Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-user"></span>
                            <input id="name" class="form-control" type="text" name="name" value="{{$station->name}}" required autofocus autocomplete="name" />
                        </div>
                        <label for="tb-remail">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-envelope"></span>
                            <input class="form-control" id="email" type="email" name="email" value="{{$station->email}}" required autocomplete="email" />
                        </div>
                        <label for="tb-remail">Phone</label>
                        <div class="valid-msg-wrap">
                             <span id="valid-msg" class="hide">✓ Valid</span>
                             <span id="error-msg" class="hide">Invalid number</span>
                         </div>
                        <div class="form-group mb-3">
                            <input class="form-control form-control-prepended" id="contact_no" type="tel" value="{{$station->phone}}" />
                        </div>
                        <input type="hidden" name="initial_country" id="initial_country" value="{{$station->initial_country}}">
                        <input type="hidden" name="country_code" id="country_code" value="{{$station->country_code}}">
                        <input type="hidden" name="phone" id="phone_complete" value="{{$station->phone}}">
                        <label for="tb-remail">Address</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-home"></span>
                            <input class="form-control" id="email" type="text" name="address" value="{{$station->address}}" required autocomplete="address" />
                        </div>
                        <label for="tb-remail">Country</label>
                        <div class="input-group mb-3">
                          <!-- <span class="input-group-text fa fa-flag"></span> -->
                          <select class="form-control select2" name="country_id" required>
                              @foreach($countries as $key => $name)
                                 <option value="{{$key}}" {{$station->country_id == $key ? 'selected' : ''}}>{{$name}}</option>
                              @endforeach
                          </select>
                        </div>
                        <label for="tb-remail">State</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-city"></span>
                            <input class="form-control" id="state" type="text" name="state" value="{{$station->state}}" required autocomplete="state" />
                        </div>
                        <div class="d-flex align-items-stretch">
                            <button type="button" data-pickup-id="{{$station->id}}" id="pickup-update-btn" class="btn btn-success">Update</button>
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
         initialCountry: "{{$station->initial_country}}",
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

    $(document).on('click', "#pickup-update-btn", function() {

        let id = $(this).data("pickup-id");
        let url = "{{route('pickup-station.update', ['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#pickup-update-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, null, null)

    })
</script>
@endpush