@extends('admin.layout.master')

@section('content')
 
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Settings</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
            <li class="breadcrumb-item active">Setting</li>
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
                            <h4 class="card-title mb-0">Settings</h4>
                        </div>
                        <div class="col-6 text-end">
                            <!-- <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Add Mode</button> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex active" data-bs-toggle="tab" href="#settings" role="tab">
                                <span><i class="ti-home"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Settings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#freight" role="tab">
                                <span><i class="ti-user"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Freight</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="setting-edit-form" action="javascript:void(0)">  
                                        <div class="mb-3 row">
                                            <label for="fname" class="col-sm-3 text-start control-label col-form-label">Waybill No:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="waybil_no" name="waybil_no" value="{{$Setting->setting->waybil_no ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="fname" class="col-sm-3 text-start control-label col-form-label">Email:</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="email" name="email" value="{{$Setting->setting->email ?? ''}}" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="lname" class="col-sm-3 text-start control-label col-form-label">Customer No:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="customer_no" name="customer_no" value="{{$Setting->setting->customer_no ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="referal_no" class="col-sm-3 text-start control-label col-form-label">Referral:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="referal_no" name="referal_no" value="{{$Setting->setting->referal_no ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">User Page View:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="user_page_view" name="user_page_view" value="{{$Setting->setting->user_page_view ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div> 
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Admin Page View:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="admin_page_view" name="admin_page_view" value="{{$Setting->setting->admin_page_view ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Address 1:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="address1" name="address1" value="{{$Setting->setting->address1 ?? ''}}" placeholder="Type Address 1">
                                            </div>
                                        </div> 
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Address 2:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="address2" name="address2" value="{{$Setting->setting->address2 ?? ''}}" placeholder="Type Address 2">
                                            </div>
                                        </div>
                                        <div class="valid-msg-wrap">
                                                 <span id="valid-msg" class="hide">✓ Valid</span>
                                                 <span id="error-msg" class="hide">Invalid number</span>
                                             </div>
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Phone</label>
                                            
                                            <div class="col-sm-9">
                                                <input class="form-control" name="contact_no" id="contact_no" type="tel" value="{{$Setting->setting->phone ?? ''}}" />
                                            </div>
                                            <input type="hidden" name="initial_country" id="initial_country" value="{{$Setting->setting->initial_country ?? ''}}">
                                            <input type="hidden" name="country_code" id="country_code" value="{{$Setting->setting->country_code ?? ''}}">
                                            <input type="hidden" name="phone" id="phone_complete" value="{{$Setting->setting->phone ?? ''}}">
                        
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Country</label>
                                            <div class="col-sm-9">
                                              <!-- <span class="input-group-text fa fa-flag"></span> -->
                                              <select class="form-control country-select" name="country_id" style="width: 90%;">
                                                  @foreach($countries as $key => $name)
                                                     <option value="{{$key}}" {{@$Setting->setting->country_id == $key ? 'selected' : ''}}>{{$name}}</option>
                                                  @endforeach
                                              </select>
                                            </div>
                                        </div>  
                                        <div class="mb-3 row">
                                            <label for="fname" class="col-sm-3 text-start control-label col-form-label">Invoice No:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="invoice_no" name="invoice_no" value="{{$Setting->setting->invoice_no ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Invoice Address:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="online_shop_invoice_address" name="online_shop_invoice_address" value="{{$Setting->setting->online_shop_invoice_address ?? ''}}" placeholder="Invoice Address">
                                            </div>
                                        </div> 
                                        
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Invoice Disclaimer:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="invoice_disclaimer" name="invoice_disclaimer" value="{{$Setting->setting->invoice_disclaimer ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div> 
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Registration Disclaimer:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="registration_disclaimer" name="registration_disclaimer" value="{{$Setting->setting->registration_disclaimer ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div> 
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Calculator Disclaimer:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="calculator_disclaimer" name="calculator_disclaimer" value="{{$Setting->setting->calculator_disclaimer ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div> 
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Shop Order Disclaimer:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="shop_order_disclaimer" name="shop_order_disclaimer" value="{{$Setting->setting->shop_order_disclaimer ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div> 
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Site Maintenance:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="site_maintenance_disclaimer" name="site_maintenance_disclaimer" value="{{$Setting->setting->site_maintenance_disclaimer ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>   
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button  class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="setting-edit-button" data-setting-id="{{$Setting->id}}">Save</button> 
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane  p-3" id="freight" role="tabpanel">
                        <div class="p-3 text-start">
                                <form class="form-horizontal" id="freight-edit-form" action="javascript:void(0)"> 
                                        <div class="mb-3 row">
                                            <label for="fname" class="col-sm-3 text-start control-label col-form-label">Air Clearance Charges:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="air_clearance_charges" name="air_clearance_charges" value="{{$Setting->freight->air_clearance_charges ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="lname" class="col-sm-3 text-start control-label col-form-label">Sea Insurance:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="sea_insurance" name="sea_insurance" value="{{$Setting->freight->sea_insurance ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="email1" class="col-sm-3 text-start control-label col-form-label">Sea Shipping Price:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="sea_shipping_price" name="sea_shipping_price" value="{{$Setting->freight->sea_shipping_price ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="cono1" class="col-sm-3 text-start control-label col-form-label">Sea Clearance Charges:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="sea_clearance_charges" name="sea_clearance_charges" value="{{$Setting->freight->sea_clearance_charges ?? ''}}" placeholder="Value Here">
                                            </div>
                                        </div>  
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="freight-edit-button" data-freight-id="{{$Setting->id}}">Save</button> 
                                        </div>
                                    </div>
                                </form>
                            </div>
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
         initialCountry: "{{$Setting->setting->initial_country ?? ''}}",
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

       $(document).on('click', "#setting-edit-button", function() { 
        let id = $(this).data("setting-id"); 
        let url = "{{route('settings.setting',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-setting-mode-edit";
        let formId = "#setting-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, ModalId, id)

    })
    $(document).on('click', "#freight-edit-button", function() { 
        let id = $(this).data("freight-id"); 
        let url = "{{route('settings.freight',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-freight-mode-edit";
        let formId = "#freight-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, ModalId, id)

    })
 </script>
   

@endpush