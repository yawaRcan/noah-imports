@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Purchasing</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
            <li class="breadcrumb-item active">Update Order</li>
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
            <form class="form-horizontal" id="order-edit-form" action="javascript:void(0)">
                @csrf
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title mb-0">Update Order- #{{$order->code}}</h4>
                            </div>
                            <div class="col-6 text-end">
                                <div class="dropdown show">
                                    <button type="button" class="btn btn-dark btn_status" style="background: {{{$order->deliveryStatus->color ?? 'N/A'}}};color: '';">{{$order->deliveryStatus->name ?? 'N/A'}}</button>
                                    <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-sm">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin: 0px;">
                                        @foreach($configStatuses as $status)
                                            <li><a class="dropdown-item order-change-status" href="javascript:void(0)" data-status-id="{{$status->id}}" data-order-id="{{$order->id}}">{{$status->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Courier</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-map-marker-multiple"></span>
                                        </span>
                                        <select name="courier" id="ni-courier" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="" data-image="{{asset('assets/icons/select_default.png')}}">Select External Shipper</option>
                                            @foreach($externalShipper as $key => $val)
                                            @if($order->courier == $val->id)
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
                                <label>Order Status</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-map"></span>
                                    </span>
                                    <select name="delivery_status" id="ni-delivery-status" class="select2 form-control custom-select" style="width: 90%;">
                                        @foreach($configStatuses as $status)
                                            <option value="{{$status->id}}" {{ $order->delivery_status == $status->id ? 'selected': '' }}>{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Invoice</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$order->invoice}}" name="invoice" id="ni-invoice" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <label>AWB</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$order->awb}}" name="awb" id="ni-awb" readonly>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <label>External AWB</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$order->external_awb}}" name="external_awb" id="ni-external-awb">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Tracking</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$order->tracking}}" name="tracking" id="ni-tracking">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Status</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <select name="payment_status" class="form-control">
                                        @foreach($paymentStatuses as $status)
                                            @if($status->slug == 'paid' || $status->slug == 'unpaid')
                                                <option value="{{$status->id}}" {{ $order->payment_status_id == $status->id ? 'selected': '' }}>{{$status->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Shipping Price</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$order->shipping_price}}" name="shipping_price" id="ni-shipping-price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Tax</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$order->tax}}" name="tax" id="ni-tax">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Date Ordered</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="created_at" value="{{$order->created_at}}" id="ni-created-at" placeholder="mm/dd/yyyy">
                                        <span class="input-group-text">
                                            <i data-feather="calendar" class="feather-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="send_invoice" type="checkbox" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Send Invoice
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-1 text-center">
                        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" data-order-id="{{$order->id}}" id="order-edit-button">Update Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>



@endsection

@push('footer-script')
<script>
    // Select2 for form select fields
    $("#ni-courier").select2({
        templateResult: formatState,
        templateSelection: formatState
    });
    $("#ni-delivery-status").select2();
    $("#ni-external-shpper").select2();
    jQuery('#ni-created-at').datepicker({
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

    // Change order status
    $(document).on('click', ".order-change-status", function() {
        let status_id = $(this).data("status-id");
        let order_id = $(this).data("order-id");
        var url = "{{route('purchasing.changeOrderStatus')}}";
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'mr-2 btn btn-danger'
            },
            buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to change order status",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var request = $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        status_id: status_id,
                        order_id: order_id,
                    },
                    dataType: "json",
                });
                request.done(function(response) {
                    if (response.success) {
                        notify('success', response.success);
                    }
                    $('#ni-delivery-status').select2('val', response.status_id, true);
                    $('.btn_status').text($('#ni-delivery-status').select2('data')[0].text);
                    // $('.btn_status').css("background-color", response.order.delivery_status.color);
                });
                request.fail(function(jqXHR, textStatus) {
                    if (jqXHR.status == '422') {
                        notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary data is safe :)',
                    'error'
                )
            }
        })

    })

    $(document).on('click', "#order-edit-button", function() {

        let id = $(this).data("order-id");
        let url = "{{route('purchasing.order.update', ['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#order-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, null, null)

    })

</script>
@endpush