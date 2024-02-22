@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Consolidates</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Consolidate</a></li>
            <li class="breadcrumb-item active">Edit Consolidate</li>
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
            <form class="form-horizontal" id="consolidate-edit-form" action="javascript:void(0)">
                @csrf
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title mb-0">Edit Consolidate</h4>
                            </div>
                            <div class="col-6 text-end">
                                <!-- <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect" id="ni-reciver-address-add">Add Reciever Address</button> -->
                            </div>
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
                                        <input type="text" class="form-control" value="{{$consolidate->user->first_name}} {{$consolidate->user->last_name}}" name="full_name" readonly id="ni-full-name">
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
                                        @foreach($shipmentAddressRecive as $val)
                                        @if($consolidate->reciever_address_id == $val->id)
                                        <option value="{{$val->id}}" selected>{{$val->address}}</option>
                                        @else
                                        <option value="{{$val->id}}">{{$val->address}}</option>
                                        @endif
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

                                            @foreach($shipmentAddress as $val)
                                            @if($consolidate->sender_address_id == $val->id)
                                            <option value="{{$val->id}}" selected>{{$val->first_name}} {{$val->last_name}}</option>
                                            @else
                                            <option value="{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</option>
                                            @endif
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
                                        @if($consolidate->branch_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>From Country</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-map-marker-radius"></span>
                                        </span>
                                        <select name="from_country" id="ni-from-country" class="select2 form-control custom-select" style="width: 90%;">

                                            @foreach($countries as $key => $val)
                                            @if($consolidate->from_country_id == $key)
                                            <option value="{{$key}}" selected>{{$val}}</option>
                                            @else
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endif
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

                                        @foreach($countries as $key => $val)
                                        @if($consolidate->to_country_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
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
                                            @if($consolidate->external_shipper_id == $val->id)
                                            <option value="{{$val->id}}" data-image="{{asset('assets/icons')}}/{{$val->icon}}" selected>{{$val->name}}</option>
                                            @else
                                            <option value="{{$val->id}}" data-image="{{asset('assets/icons')}}/{{$val->icon}}">{{$val->name}}</option>
                                            @endif
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

                                        <option value="sea-freight" @if($consolidate->freight_type == "sea-freight") selected @endif >Sea Freight</option>
                                        <option value="air-freight" @if($consolidate->freight_type == "air-freight") selected @endif >Air Freight</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                                            @if($consolidate->shipment_type_id == $key)
                                            <option value="{{$key}}" selected>{{$val}}</option>
                                            @else
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endif
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
                                        @if($consolidate->shipment_mode_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
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
                                    <option value="1" @if( $consolidate->delivery_method == 1 ) selected @endif >Pickup Station</option>
                                    <option value="0" @if( $consolidate->delivery_method == 0 ) selected @endif >Door Step</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Upload Images</label>
                                    <div class="dropzone" id="myDropzone">

                                    </div>
                                    <input type="hidden" id="files-main-id">
                                </div>
                            </div>
                            <div class="col-12" id="ni-images-append">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Parcel Status</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-verified"></span>
                                        </span>
                                        <select name="parcel_status" id="ni-parcel-status" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select Parcel Status</option>
                                            @foreach($parcelStatus as $key => $val)

                                            @if($consolidate->parcel_status_id == $val->id)
                                            <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                            @else
                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                            @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Payment Status</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-verified"></span>
                                        </span>
                                        <select name="payment_status" id="ni-payment-status" class="select2 form-control custom-select" style="width: 90%;">
                                            @foreach($paymentStatuses as $status)
                                                <option value="{{$status->id}}" {{ $consolidate->payment_status_id == $status->id ? 'selected': '' }}>{{$status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>External Tracking</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-access-point-network"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$consolidate->external_tracking}}" name="external_tracking" id="ni-external-tracking">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Estimate Delivery Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="estimate_delivery_date" value="{{$consolidate->es_delivery_date}}" id="ni-estimate-delivery-date" placeholder="mm/dd/yyyy">
                                    <span class="input-group-text">
                                        <i data-feather="calendar" class="feather-sm"></i>
                                    </span>
                                </div>
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
                                        <textarea class="form-control" name="comment" id="ni-comment">{{$consolidate->comment}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ni-important" name="important" class="material-inputs filled-in chk-col-blue" checked="">
                                    <label for="ni-important">Important</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ni-show-invoice" name="show_invoice" class="material-inputs filled-in chk-col-blue" checked="">
                                    <label for="ni-show-invoice">Show Invoice</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ni-show-delivery-date" name="show_delivery_date" class="material-inputs filled-in chk-col-blue" checked="">
                                    <label for="ni-show-delivery-date">Show Delivery Date</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="ni-hidden-pickup-station" value="0" name="pickup_station">
                    <div class="p-1 text-center">
                        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" data-consolidate-id="{{$consolidate->id}}" id="consolidate-edit-button">Edit Consolidate</button>
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

@endsection

@push('footer-script')
<script>
    var myDropzone = '';
    // Select2 for form select fields
    $("#ni-sender-ship-address").select2();
    $("#ni-branch-id").select2();
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
                '<span><img src="' + optimage + '" width="60px" /> ' + opt.text.toUpperCase() + '</span>'
            );
            return $opt;
        }
    };
    // Opening of User Reciever Address Modal
    $(document).on('click', "#ni-reciver-address-add", function() {
        let url = "{{route('parcel.getrecieverhtml')}}";
        // Function to get html of Reciever Address Form
        getHtmlAjax(url, "#ni-reciver-address-add-modal", "#ni-reciver-address-body")
        setTimeout(function() {
            $('#ni-reciever-user').val($("#ni-search_id").val())
        }, 1000);
    })

    // Action On Click Reciever Address Form Add Button
    $(document).on('click', "#ni-reciever-address-add-btn", function() {

        // Collecting Current Form Data 
        forms = $("#ni-reciever-address-add-form")[0];
        var form = new FormData(forms);

        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('parcel.addreciever')}}",
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
                    $("input[name=" + index + "]").addClass('is-invalid');
                    $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                });
            }
        });

    });

    $(document).on('click', "#consolidate-edit-button", function() {
        let id = $(this).data("consolidate-id");
        let url = "{{route('consolidate.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#consolidate-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, null, null, myDropzone)
    })

    // Click action on Delivery Method Field
    $(document).on('change', "#ni-delivery-method", function() {

        let value = $(this).val();
        if (value == 1) {
            if ($("#ni-hidden-pickup-station").val() == 0) {
                // Opening of Pickup Station Select Modal 
                let url = "{{route('consolidate.getPickupStation')}}?consolidate_id={{$consolidate->id}}";
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

    Dropzone.options.myDropzone = {
        autoProcessQueue: false,
        uploadMultiple: true,
        addRemoveLinks: true,
        maxFilesize: 10,
        maxFiles: 10,
        parallelUploads: 10,
        paramName: "file",
        acceptedFiles: 'image/*',
        url: "{{ route('consolidate.file.store') }}",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Drag and drop files here or click to upload',
        dictFallbackMessage: 'Your browser does not support drag and drop file uploads.',
        init: function() {
            myDropzone = this;
            myDropzone.on('sending', function(file, xhr, formData) {
      
                var id = $('#files-main-id').val();
                formData.append('consolidate_id', id);
            });
            myDropzone.on("success", function(file, response) {
                setTimeout(function() {
                    location.href = "{{route('consolidate.index')}}"
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