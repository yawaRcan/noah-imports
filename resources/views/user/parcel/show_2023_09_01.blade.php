@extends('user.layout.master')

@section('content')
<style type="text/css">
    body {
        margin-top: 20px;
    }

    .steps .step {
        display: block;
        width: 100%;
        margin-bottom: 35px;
        text-align: center
    }

    .steps .step .step-icon-wrap {
        display: block;
        position: relative;
        width: 100%;
        height: 80px;
        text-align: center
    }

    .steps .step .step-icon-wrap::before,
    .steps .step .step-icon-wrap::after {
        display: block;
        position: absolute;
        top: 50%;
        width: 50%;
        height: 3px;
        margin-top: -1px;
        background-color: #e1e7ec;
        content: '';
        z-index: 1
    }

    .steps .step .step-icon-wrap::before {
        left: 0
    }

    .steps .step .step-icon-wrap::after {
        right: 0
    }

    .steps .step .step-icon {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        border: 1px solid #e1e7ec;
        border-radius: 50%;
        background-color: #f5f5f5;
        color: #374250;
        font-size: 38px;
        line-height: 81px;
        z-index: 5
    }

    .steps .step .step-title {
        margin-top: 16px;
        margin-bottom: 0;
        color: #606975;
        font-size: 14px;
        font-weight: 500
    }

    .steps .step:first-child .step-icon-wrap::before {
        display: none
    }

    .steps .step:last-child .step-icon-wrap::after {
        display: none
    }

    .steps .step.completed .step-icon-wrap::before,
    .steps .step.completed .step-icon-wrap::after {
        background-color: #0da9ef
    }

    .steps .step.completed .step-icon {
        border-color: #0da9ef;
        background-color: #0da9ef;
        color: #fff
    }

    @media (max-width: 576px) {

        .flex-sm-nowrap .step .step-icon-wrap::before,
        .flex-sm-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 768px) {

        .flex-md-nowrap .step .step-icon-wrap::before,
        .flex-md-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 991px) {

        .flex-lg-nowrap .step .step-icon-wrap::before,
        .flex-lg-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 1200px) {

        .flex-xl-nowrap .step .step-icon-wrap::before,
        .flex-xl-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    .bg-faded,
    .bg-secondary {
        background-color: #f5f5f5 !important;
    }
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcels</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Parcel</a></li>
            <li class="breadcrumb-item active">View Shipment</li>
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
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Parcel Tracking information</h4>
                </div>
                <div class="p-4 text-center text-white text-lg rounded-top" style="background-color: #26C6DA;"><span class="text-uppercase">Tracking No - </span><span class="text-medium">{{$parcel->external_tracking ?? 'N/A'}}</span></div>
                <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
                    <div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped Via:</span> {{$parcel->externalShipper->name ?? 'N/A'}}</div>
                    <div class="w-100 text-center py-1 px-2"><span class="text-medium">Status:</span> {{$parcel->parcelStatus->name ?? 'N/A'}}</div>
                    <div class="w-100 text-center py-1 px-2"><span class="text-medium">Delivery Date:</span> {{date('d-M-y', strtotime($parcel->es_delivery_date))}}</div>
                </div>
                <div class="card-body">
                    <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                        @foreach($statuses as $status)
                        @php
                        if($parcel->parcelStatus->slug == 'at-warehouse-miami')
                            $parcelStatusId = 1;
                        else
                            $parcelStatusId = $parcel->parcelStatus->id;
                        @endphp
                          <div class="step {{$parcelStatusId >= $status->id ? 'completed' : ''}}">
                            <div class="step-icon-wrap">
                                <div class="step-icon">
                                    @if($status->slug == 'pending')
                                    <i class="fas fa-clock"></i>
                                    @elseif($status->slug == 'processing')
                                    <i class="fas fa-box-open"></i>
                                    @elseif($status->slug == 'in-transit')
                                    <i class="fas fa-shipping-fast"></i>
                                    @elseif($status->slug == 'in-transit-to-be-delivered')
                                    <i class="fas fa-warehouse"></i>
                                    @elseif($status->slug == 'delivered')
                                    <i class="fas fa-home"></i>
                                    @else
                                    <i class="fas fa-home"></i>
                                    @endif
                                </div>
                            </div>
                            <h4 class="step-title">{{ucwords($status->name)}}</h4>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @if(!is_null($onlineTracking))
                <div class="d-flex flex-wrap flex-md-nowrap justify-content-center justify-content-sm-between align-items-center">
                    <div class="text-left text-sm-right"><a class="btn btn-outline-primary btn-rounded btn-sm" href="javascript:void(0)" data-parcel-id="{{$parcel->id}}" id="ni-get-online-tracking">View Online Tracking</a></div>
                </div>
                <div id="ni-online-tracking-data" class="hide mt-3">
                    <div class="card mb-3">
                        <div class="p-4 text-center text-white text-lg rounded-top" style="background-color: #26C6DA;"><span class="text-uppercase">Online Tracking No - </span><span class="text-medium">{{$parcel->external_tracking ?? 'N/A'}}</span></div>
                        <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
                            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped Via:</span> <br> {{$onlineTracking['data']['shipment_type'] ?? 'N/A'}}</div>
                            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Current Status:</span><br> {{$onlineTracking['data']['tag'] ?? 'N/A'}}</div>
                            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Delivery Date:</span> <br>{{date('d-M-y', strtotime($onlineTracking['full_data']['expected_delivery'] ?? 'N/A'))}}</div>
                            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Current Location:</span> <br>{{$onlineTracking['data']['checkpoints'][$lastIndex]['location'] ?? 'N/A'}}</div>
                        </div>
                        <div class="card-body">
                            <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                                @foreach($onlineStatuses as $status)
                                <div class="step {{$status['value'] <= $statusValue ? 'completed' : ''}}">
                                    <div class="step-icon-wrap">
                                        <div class="step-icon">
                                            @if($status['status'] == 'Pending')
                                            <i class="fas fa-clock"></i>
                                            @elseif($status['status'] == 'InfoReceived')
                                            <i class="fas fa-box-open"></i>
                                            @elseif($status['status'] == 'InTransit')
                                            <i class="fas fa-shipping-fast"></i>
                                            @elseif($status['status'] == 'OutForDelivery')
                                            <i class="fas fa-warehouse"></i>
                                            @elseif($status['status'] == 'Delivered')
                                            <i class="fas fa-home"></i>
                                            @endif
                                        </div>
                                    </div>
                                    @if($status['status'] == 'InfoReceived')
                                    <h4 class="step-title">{{ucwords('Processing')}}</h4>
                                    @elseif($status['status'] == 'OutForDelivery')
                                    <h4 class="step-title">{{ucwords('In Transit To Be Delivered')}}</h4>
                                    @else
                                    <h4 class="step-title">{{ucwords($status['status'])}}</h4>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Invoice #{{$parcel->invoice_no ?? 'N/A'}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Waybill: <span class="fw-bold">{{$parcel->waybill ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Status : <span class="mb-1 badge text-white" style="background-color: {{$parcel->parcelStatus->color  ?? 'N/A'}} ">{{$parcel->parcelStatus->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Payment Status : <span class="mb-1 badge text-white" style="background-color: {{$parcel->paymentStatus->color  ?? 'N/A'}} ">{{$parcel->paymentStatus->name ?? 'N/A'}}</span></p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Shipment Type</p>
                            <p> <span class="card-text">{{$parcel->shipmentType->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Shipment Mode</p>
                            <p> <span class="card-text">{{$parcel->shipmentMode->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Freight Type</p>
                            <p> <span class="card-text">{{$parcel->freight_type ?? 'N/A'}}</span></p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Amount</p>
                            <p> <span class="card-text">{{$parcel->amount_total ? 'ƒ '.number_format($parcel->amount_total, 2).' ANG' : 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Payment Method</p>
                            <p> <span class="card-text">{{$parcel->payment->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Estimated delivery date</p>
                            <p> <span class="card-text">{{$parcel->es_delivery_date ?? 'N/A'}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Item description
                        @if($parcel->parcelImages->isNotEmpty())
                            <a href="javascript:void(0)" class="btn btn-info ni-show-images p-1" data-parcel-id="{{$parcel->id}}">Show Images</a>
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Quantity</th>
                                    <th>Item Value</th>
                                    <th>DESCRIPTION:</th>
                                    <th>CATEGORY</th>
                                    <th>WEIGHT (LB)</th>
                                    <th>LENGTH (INCH)</th>
                                    <th>WIDTH (INCH)</th>
                                    <th>HEIGHT (INCH)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{$parcel->quantity ?? 'N/A'}}</td>
                                    <td>{{$parcel->item_value ?? 'N/A'}}</td>
                                    <td>{{$parcel->product_description ?? 'N/A'}}</td>
                                    <td>{{$parcel->duty->name ?? 'N/A'}}</td>
                                    <td>{{$parcel->weight ?? 'N/A'}}</td>
                                    <td>{{$parcel->length ?? 'N/A'}}</td>
                                    <td>{{$parcel->width ?? 'N/A'}}</td>
                                    <td>{{$parcel->height ?? 'N/A'}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-4">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Origin</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <p class="card-text">Name : <span class="fw-bold">{{$parcel->sender->address ?? 'N/A'}}</span></p>
                    <p class="card-text">Email : <span class="fw-bold">{{$parcel->sender->email ?? 'N/A'}}</span></p>
                    <p class="card-text">Phone : <span class="fw-bold">{{$parcel->sender->phone ?? 'N/A'}}</span></p>
                    <p class="card-text">Country : <span class="fw-bold">{{$parcel->sender->country->name ?? 'N/A'}}</span></p>
                    <p class="card-text">Address : <span class="fw-bold">{{$parcel->sender->address ?? 'N/A'}}</span></p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Destination</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <p class="card-text">Name : <span class="fw-bold">{{$parcel->branch->name ?? 'N/A'}}</span></p>
                    <p class="card-text">Email : <span class="fw-bold">{{$parcel->branch->email ?? 'N/A'}}</span></p>
                    <p class="card-text">Phone : <span class="fw-bold">{{$parcel->branch->phone ?? 'N/A'}}</span></p>
                    <p class="card-text">Country : <span class="fw-bold">{{$parcel->branch->country ?? 'N/A'}}</span></p>
                    <p class="card-text">Address : <span class="fw-bold">{{$parcel->branch->address ?? 'N/A'}}</span></p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Delivery Address</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <p class="card-text">Name : <span class="fw-bold">{{$parcel->reciever->address ?? 'N/A'}}</span></p>
                    <p class="card-text">Email : <span class="fw-bold">{{$parcel->reciever->email ?? 'N/A'}}</span></p>
                    <p class="card-text">Phone : <span class="fw-bold">{{$parcel->reciever->phone ?? 'N/A'}}</span></p>
                    <p class="card-text">Country : <span class="fw-bold">{{$parcel->reciever->country->name ?? 'N/A'}}</span></p>
                    <p class="card-text">Address : <span class="fw-bold">{{$parcel->reciever->address ?? 'N/A'}}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




<!-- Add modal content -->
<div class="modal fade" id="ni-show-images-modal" tabindex="-1" aria-labelledby="ni-show-images-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Reciever Address</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-show-images-modal-body">

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
    // Select2 for form select fields
    $("#ni-sender-ship-address").select2();
    $("#ni-branch-id").select2();
    $("#ni-external-shpper").select2();
    $("#ni-freight-type").select2();
    $("#ni-shipment-type").select2();
    $("#ni-shipment-mode").select2();
    $("#ni-from-country").select2();
    $("#ni-to-country").select2();
    jQuery('#ni-estimate-delivery-date').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    // Opening of User Reciever Address Modal
    $(document).on('click', "#ni-reciver-address-add", function() {
        let url = "{{route('user.parcel.getrecieverhtml')}}";
        // Function to get html of Reciever Address Form
        getHtmlAjax(url, "#ni-reciver-address-add-modal", "#ni-reciver-address-body")
        setTimeout(function() {
            $('#ni-reciever-user').val($("#ni-search_id").val())
        }, 1000);
    })

    // Opening show Images Modal 
    $(document).on('click', ".ni-show-images", function() {
        let id = $(this).data("parcel-id");
        let url = "{{route('user.parcel.imagesGet',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Images Form
        getHtmlAjax(url, "#ni-show-images-modal", "#ni-show-images-modal-body")

    })

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
                    $("input[name=" + index + "]").addClass('is-invalid');
                    $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                });
            }
        });

    });

    $('#ni-get-online-tracking').click(function(e) {

        $("#ni-online-tracking-data").slideToggle();
    })

    $(document).on('click', "#parcel-edit-button", function() {
        let id = $(this).data("parcel-id");
        let url = "{{route('user.parcel.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#parcel-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId)
    })
</script>
@endpush