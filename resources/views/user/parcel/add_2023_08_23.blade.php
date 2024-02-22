@extends('user.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcels</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Parcel</a></li>
            <li class="breadcrumb-item active">Create Shipment</li>
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
            <form class="form-horizontal" id="parcel-add-form" action="javascript:void(0)">
                @csrf
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title mb-0">Create Shipment</h4>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect" id="ni-reciver-address-add">Add Reciever Address</button>
                            </div>
                            <!-- <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <select class="form-control custom-select" id="ni-search_id" name="search_user_id" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="">
                                        <a href="#" id="ni-user-spin" style="font-size: 25px;" class="hide">
                                            <div class="spinner-border spinner-border-sm mb-3" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </a>
                                        <a href="#" class="mdi-check-btn hide" style="font-size: 20px;">
                                            <span class="mdi mdi-check-circle"></span>
                                        </a>
                                        <a href="#" class="mdi-cross-btn hide text-danger" style="font-size: 20px;">
                                            <span class="mdi mdi-account-off"></span>
                                        </a>
                                        <span class="text-danger reciver-error-text"></span>

                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Full Name</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-account-check"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}" name="full_name" id="ni-full-name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Reciever's Address</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-account-location"></span>
                                    </span>
                                    <select name="reciver_ship_address" id="ni-reciver-ship-address" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Reciever's Address</option>
                                        @foreach($reciver as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Sender's Address</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-map-marker-multiple"></span>
                                        </span>
                                        <select name="sender_ship_address" id="ni-sender-ship-address" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select Sender's Address</option>
                                            @foreach($shipmentAddress as $val)
                                            <option value="{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Branch Destination's</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-map"></span>
                                    </span>
                                    <select name="branch_id" id="ni-branch-id" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Branch Destination's</option>
                                        @foreach($branches as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                       <!--  <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>From Country</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-map-marker-radius"></span>
                                        </span>
                                        <select name="from_country" id="ni-from-country" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select from country</option>
                                            @foreach($countries as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>To Country</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-map-marker-radius"></span>
                                    </span>
                                    <select name="to_country" id="ni-to-country" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select to country</option>
                                        @foreach($countries as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>External Shipper</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-server"></span>
                                        </span>
                                        <select name="external_shpper" id="ni-external-shpper" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="" data-image="{{asset('assets/icons/select_default.png')}}">Select External Shipper</option>
                                            @foreach($externalShipper as $key => $val)
                                            <option value="{{$val->id}}" data-image="{{asset('assets/icons')}}/{{$val->icon}}">{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Freight Type</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-speedometer"></span>
                                    </span>
                                    <select name="freight_type" id="ni-freight-type" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Freight Type</option>
                                        <option value="sea-freight">Sea Freight</option>
                                        <option value="air-freight">Air Freight</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Shipment Type</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-wallet-membership"></span>
                                        </span>
                                        <select name="shipment_type" id="ni-shipment-type" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select Shipment Type</option>
                                            @foreach($shipmentTypes as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Shipment Mode</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-wan"></span>
                                    </span>
                                    <select name="shipment_mode" id="ni-shipment-mode" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Shipment Mode</option>
                                        @foreach($shipmentMode as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Quantity</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="0" name="quantity" id="ni-quantity">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Item Value</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="0" name="item_value" id="ni-item-value">
                                    </div>
                                </div>
                            </div> 
                            <!-- <div class="col-md-6">
                                <label>Upload Images</label>
                                <div class="dropzone" id="myDropzone">

                                </div>
                                <input type="hidden" id="files-main-id">
                            </div>
                            <div class="col-12" id="ni-images-append">

                            </div> -->
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Product Description</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-sort-descending"></span>
                                        </span>
                                        <textarea class="form-control" name="product_desc" id="ni-product-desc"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Import Duties</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <select name="import_duties" id="ni-import-duties" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select Import Duties</option>
                                            @foreach($importDuties as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 text-start">
                                        <label>Delivery Method</label>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="mdi mdi-autorenew hide" id="ni-change-station" style="font-size:20px;cursor:pointer;"></span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-comment-alert-outline"></span>
                                    </span>
                                    <select name="delivery_method" id="ni-delivery-method" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Delivery Method</option>
                                        <option value="1">Pickup Station</option>
                                        <option value="0">Door Step</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Delivery Fees</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="0" name="delivery_fees" id="ni-delivery-fees">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 text-start">
                                        <label>OB ( % )</label>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-comment-alert-outline"></span>
                                    </span>
                                    <select name="ob_fees" id="ni-ob-fees" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select OB Fees</option>
                                        <option value="1">0 %</option>
                                        <option value="6">6 %</option>
                                        <option value="9" selected>9 %</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="row"> 
                            
                            <!-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label>External Waybill</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="0" name="external_awb" id="ni-external-awb">
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 text-start">
                                        <label>Parcel Discount</label>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="mdi mdi-autorenew" id="ni-change-discount" style="font-size:20px;cursor:pointer;"></span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-comment-alert-outline"></span>
                                    </span>
                                    <select name="discount_type" id="ni-discount-type" class="select2 form-control custom-select" style="width: 90%;">
                                        <!-- <option value="">Select Discount</option> -->
                                        <option value="ship" id="ni-ship-percentage">Shipment Discount ( 0 )</option>
                                        <option value="total" selected id="ni-total-percentage">Total Discount ( 0 )</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Payment Method</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-cash"></span>
                                        </span>
                                        <select name="payment_method" id="ni-payment-method" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select Payment Method</option>
                                            @foreach($payments as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div> 
                            <!-- <div class="col-md-6">
                                <label>Tax</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-percent"></span>
                                    </span>
                                    <input type="text" class="form-control" value="0" name="tax" id="ni-tax">
                                </div>
                            </div> -->
                        </div>  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>External Tracking</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-access-point-network"></span>
                                        </span>
                                        <input type="text" class="form-control" value="0" name="external_tracking" id="ni-external-tracking">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Estimate Delivery Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="estimate_delivery_date" id="ni-estimate-delivery-date" placeholder="mm/dd/yyyy">
                                    <span class="input-group-text">
                                        <i data-feather="calendar" class="feather-sm"></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label>Upload Payment Receipt</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-file-image"></span>
                                    </span>
                                    <input type="file" class="form-control" name="payment_file" id="ni-payment-file">
                                </div>
                            </div>
                            <div class="col-12" id="ni-payment-file-append">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Comement</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-sort-descending"></span>
                                        </span>
                                        <textarea class="form-control" name="comment" id="ni-comment"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <input type="hidden" id="ni-hidden-pickup-station" value="0" name="pickup_station">
                    <input type="hidden" id="ni-hidden-discount" value="0" name="discount">
                    <div class="p-1 text-center">
                        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="parcel-add-button">Add Shipment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>




<!-- Add modal content -->
<div class="modal fade" id="ni-reciver-address-add-modal" tabindex="-1" aria-labelledby="ni-reciver-address-add-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Reciever Address</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-reciver-address-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Add modal content -->
<div class="modal fade" id="ni-pickup-station-modal" tabindex="-1" aria-labelledby="ni-pickup-station-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Select Pickup Station</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-pickup-station-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Add modal content -->
<div class="modal fade" id="ni-dicount-modal" tabindex="-1" aria-labelledby="ni-dicount-modal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="ni-discount-text">Parcel Discount</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-dicount-body">
                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <span class="mdi mdi-access-point-network"></span>
                        </span>
                        <input type="text" class="form-control ni-dicount-val" id="ni-dicount-val-ship" value="0">
                        <input type="text" class="form-control ni-dicount-val" id="ni-dicount-val-total" value="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@push('footer-script')
<script>
    var myDropzone = '';
    // Searching Users From the User select field
    $("#ni-search_id").select2({
        placeholder: "Select a user",
        allowClear: true,
        ajax: {
            url: "{{route('user.parcel.getusers')}}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                $('.reciver-error-text').html('')
                $('.mdi-check-btn').addClass('hide');
                $('.mdi-cross-btn').addClass('hide');
                $('#ni-user-spin').removeClass('hide');
                return {
                    q: params.term, // search term 
                };
            },
            processResults: function(data) {
                // Appending Data to User select Field
                var arr = []
                $.each(data.items, function(index, value) {
                    arr.push({
                        id: value.id,
                        text: value.first_name + ' ' + value.last_name
                    })
                });
                $('#ni-user-spin').addClass('hide');
                return {
                    results: arr
                };
            },
            cache: true,
        },
        minimumInputLength: 1
    });


    // Select2 for form select fields
    $("#ni-sender-ship-address").select2();
    $("#ni-branch-id").select2();
    $("#ni-reciver-ship-address").select2({
        placeholder: "Select Reciever Address",
    });
    $("#ni-external-shpper").select2({
        templateResult: formatState,
        templateSelection: formatState
    });
    $("#ni-freight-type").select2();
    $("#ni-shipment-type").select2();
    $("#ni-shipment-mode").select2();
    $("#ni-from-country").select2();
    $("#ni-to-country").select2();
    jQuery('#ni-estimate-delivery-date').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    function formatState(opt) {
        if (!opt.id) {
            return opt.text.toUpperCase();
        }

        var optimage = $(opt.element).attr('data-image');

        if (!optimage) {
            return opt.text.toUpperCase();
        } else {
            var $opt = $(
                '<span><img src="' + optimage + '" width="40px" /> ' + opt.text.toUpperCase() + '</span>'
            );
            return $opt;
        }
    };

    $(document).on('change', "#ni-external-tracking", function() {

        var tracking = $(this).val();

        let url = "{{route('user.parcel.exist.data',['tracking'=> '!tracking'])}}";
        url = url.replace('!tracking', tracking);
    if(tracking){ 
  
        var request = $.ajax({
            url: url,
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
        });
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                notify('success', response.success);
            }
            if (response.data) {
                $("#ni-sender-ship-address").val(response.data.sender_address_id).trigger('change');
                $("#ni-branch-id").val(response.data.branch_id).trigger('change');
                $("#ni-from-country").val(response.data.from_country_id).trigger('change');
                $("#ni-to-country").val(response.data.to_country_id).trigger('change');
                $("#ni-external-shpper").val(response.data.external_shipper_id).trigger('change');
                $("#ni-freight-type").val(response.data.freight_type).trigger('change');
                $("#ni-shipment-type").val(response.data.shipment_type_id).trigger('change');
                $("#ni-shipment-mode").val(response.data.shipment_mode_id).trigger('change');
                $("#ni-quantity").val(response.data.quantity);
                $("#ni-weight").val(response.data.weight);
                $("#ni-dimention").val(response.data.dimension);
                $("#ni-length-inch").val(response.data.length);
                $("#ni-width-inch").val(response.data.width);
                $("#ni-height-inch").val(response.data.height);
                $("#ni-product-desc").val(response.data.product_description);
                $("#ni-import-duties").val(response.data.import_duty_id).trigger('change');
                $("#ni-delivery-method").val(response.data.delivery_method);
                if (response.data.delivery_method > 0) {
                    $("#ni-hidden-pickup-station").val(response.data.pickup_station_id);
                }
                $("#ni-delivery-fees").val(response.data.delivery_fee);
                $("#ni-ob-fees").val(response.data.ob_fees);
                $("#ni-item-value").val(response.data.item_value);
                $("#ni-external-awb").val(response.data.external_waybill);
                $("#ni-discount-type").val(response.data.discount_type);
                if (response.data.discount_type == 'total') {
                    $("#ni-dicount-val-total").val(response.data.discount);
                    $("#ni-hidden-discount").val(response.data.discount);
                } else {
                    $("#ni-dicount-val-ship").val(response.data.discount);
                    $("#ni-hidden-discount").val(response.data.discount);
                }
                $("#ni-tax").val(response.data.tax);
                $("#ni-parcel-status").val(response.data.parcel_status_id);
                $("#ni-estimate-delivery-date").val(response.data.es_delivery_date);
                $("#ni-payment-method").val(response.data.payment_id);
                $("#ni-payment-status").val(response.data.payment_status_id);
                $("#ni-comment").val(response.data.comment);
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            if (jqXHR.status) {
                notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
            }
        });
    }

    });

    // Ajax Action of checking Selected User Addresses 
    $(document).on('change', "#ni-search_id", function() {

        let id = $(this).val();
        $('#ni-user-spin').removeClass('hide');
        $('.reciver-error-text').html('')
        $('.mdi-check-btn').addClass('hide');
        $('.mdi-cross-btn').addClass('hide');
        if (id != "undefined" && id != null && id != '') {
            var request = $.ajax({
                url: "{{route('user.parcel.checkReciverAdd')}}",
                method: "GET",
                dataType: "json",
                data: {
                    id: id
                },
            });
            // Done Action of checking Selected User Addresses 
            request.done(function(response) {

                if (response.error != '' && response.error != 'undefined' && response.error != null) {
                    $('#ni-user-spin').addClass('hide');
                    $('.reciver-error-text').html(response.error)
                    $('.mdi-check-btn').addClass('hide');
                    $('.mdi-cross-btn').removeClass('hide');
                    $('#ni-reciver-address-add').removeAttr("disabled");
                } else {
                    $('#ni-user-spin').addClass('hide');
                    $('.reciver-error-text').html('')
                    $('.mdi-check-btn').removeClass('hide');
                    $('.mdi-cross-btn').addClass('hide');
                    $('#ni-reciver-address-add').removeAttr("disabled");

                }

                $('#ni-full-name').val(response.full_name)
                $("#ni-reciver-ship-address").empty();
                $.each(response.addresses, function(index, value) {
                    var newOption = new Option(value.name, value.id, false, false);
                    $('#ni-reciver-ship-address').append(newOption).trigger('change');
                });



            });
            // Fail Action of checking Selected User Addresses 
            request.fail(function(jqXHR, textStatus) {

                if (jqXHR.status) {
                    notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
                }
            });
        }



    })

    // Opening of User Reciever Address Modal
    $(document).on('click', "#ni-reciver-address-add", function() {
        let url = "{{route('user.parcel.getrecieverhtml')}}";
        // Function to get html of Reciever Address Form
        getHtmlAjax(url, "#ni-reciver-address-add-modal", "#ni-reciver-address-body")
        setTimeout(function() {
            $('#ni-reciever-user').val($("#ni-search_id").val())
        }, 1000);
    })

    // Click action on Delivery Method Field
    $(document).on('change', "#ni-delivery-method", function() {

        let value = $(this).val();
        if (value == 1) {
            if ($("#ni-hidden-pickup-station").val() == 0) {
                // Opening of Pickup Station Select Modal 
                let url = "{{route('user.parcel.getPickupStation')}}";
                // Function to get html of Pickup Station Modal 
                getHtmlAjax(url, "#ni-pickup-station-modal", "#ni-pickup-station-body")
                // Show pickup station change icon
                $("#ni-change-station").show()
            } else {
                // Opening of Pickup Station Select Modal 
                $("#ni-pickup-station-modal").modal('show')
                // Show pickup station change icon
                $("#ni-change-station").show()
            }
        } else {
            $("#ni-change-station").hide()
        }

    })

    $(document).on('click', "#ni-change-station", function() {
        // Opening of Pickup Station Select Modal 
        $("#ni-pickup-station-modal").modal('show')
    })

    $("#ni-payment-file").change(function() {
        filePreview(this);
    });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-exship-payment-add-preview').remove();

                if (input.files[0].type.indexOf('image') === 0) {
                  // If it's an image, display it in the file preview
                  $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                } else {
                  // If it's not an image, display the document icon
                  $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }



    // Action On Click Reciever Address Form Add Button
    $(document).on('click', "#ni-reciever-address-add-btn", function() {

        // Collecting Current Form Data 
        forms = $("#ni-reciever-address-add-form")[0];
        var form = new FormData(forms);

        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('user.parcel.addreciever')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: form,
        });
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                notify('success', response.success);
            }

            // Hiding Current modal
            $("#ni-reciver-address-add-modal").modal('hide');
            // Empty the current modal
            $('.modal-body').html('');
            // Appending values to Reciever address Select data
            if (response.value) {
                var newOption = new Option(response.value.name, response.value.id, false, false);
                $('#ni-reciver-ship-address').append(newOption).trigger('change');
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            if (jqXHR.status == '422') {
                notify('error', "The Given Data Is Invalid");
                $('.invalid-feedback').remove()
                $(":input").removeClass('is-invalid')
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function(index, value) {
                    if ($("input[name=" + index + "]").length) {
                        $("input[name=" + index + "]").addClass('is-invalid');
                        $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }


                    if ($("select[name=" + index + "]").length) {
                        $("select[name=" + index + "]").addClass('is-invalid');
                        $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                    if ($("textarea[name=" + index + "]").length) {
                        $("textarea[name=" + index + "]").addClass('is-invalid');
                        $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                });
            }
        });

    });

    $(document).on('click', "#parcel-add-button", function() {

        let url = "{{route('user.parcel.store')}}";
        let formId = "#parcel-add-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, null, null, null)

    })

    $(document).on('change', "#ni-discount-type", function() {
        let val = $(this).val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'ship') {
                $('#ni-discount-text').html('Shipment Discount');
                $('#ni-dicount-val-total').hide();
                $('#ni-dicount-val-ship').show();
                $('#ni-ship-percentage').text('Shipment Discount ('+$('#ni-dicount-val-ship').val()+" )");
            } else {
                $('#ni-discount-text').html('Total Discount');
                $('#ni-dicount-val-ship').hide();
                $('#ni-dicount-val-total').show();
                $('#ni-total-percentage').text('Total Discount ('+$('#ni-dicount-val-total').val()+" )");
            }
            $('#ni-dicount-modal').modal('show')
        }
    })
    $(document).on('click', "#ni-change-discount", function() {
        let val = $('#ni-discount-type').val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'ship') {
                $('#ni-discount-text').html('Shipment Discount');
                $('#ni-dicount-val-total').hide();
                $('#ni-dicount-val-ship').show(); 
                $('#ni-ship-percentage').text('Shipment Discount ('+$('#ni-dicount-val-ship').val()+" )");
            } else {
                $('#ni-discount-text').html('Total Discount');
                $('#ni-dicount-val-ship').hide();
                $('#ni-dicount-val-total').show();
                $('#ni-total-percentage').text('Total Discount ('+$('#ni-dicount-val-total').val()+" )");
            }
            $('#ni-dicount-modal').modal('show')
        }
    })
    $(document).on('change', ".ni-dicount-val", function() {
        $("#ni-hidden-discount").val($(this).val());
    })

    $(document).on('keyup', "#ni-dicount-val-ship", function() {
        let val = $('#ni-discount-type').val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'ship') { 
                $('#ni-ship-percentage').text('Shipment Discount ('+$('#ni-dicount-val-ship').val()+" )");
            }   
        }
    })

    $(document).on('keyup', "#ni-dicount-val-total", function() {
        let val = $('#ni-discount-type').val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'total') { 
                $('#ni-total-percentage').text('Total Discount ('+$('#ni-dicount-val-total').val()+" )");
            }   
        }
    })

    Dropzone.options.myDropzone = {
        autoProcessQueue: false,
        uploadMultiple: true,
        addRemoveLinks: true,
        maxFilesize: 10,
        maxFiles: 10,
        parallelUploads: 10,
        paramName: "file",
        acceptedFiles: 'image/*',
        url: "{{ route('user.parcel.file.store') }}",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Drag and drop files here or click to upload',
        dictFallbackMessage: 'Your browser does not support drag and drop file uploads.',
        init: function() {
            myDropzone = this;
            myDropzone.on('sending', function(file, xhr, formData) {
      
                var id = $('#files-main-id').val();
                formData.append('parcel_id', id);
            });
            myDropzone.on("success", function(file, response) {
                setTimeout(function() {
                    location.href = "{{route('user.parcel.index')}}"
                }, 1000);
            });
            myDropzone.on("removedfile", function(file) {
                var previewElement = file.previewElement;
                if (previewElement) {
                    previewElement.parentNode.removeChild(previewElement);
                }
            });

        }
    };
</script>
@endpush