@extends('admin.layout.master')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/dropzone/dist/min/dropzone.min.css')}}">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Order</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchasing</a></li>
            <li class="breadcrumb-item active">Payment</li>
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
            <div class="card col-md-9">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Payment Information</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="payment_info">
                    {!! $order->payment->information ?? '' !!}
                </div>
            </div>
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Upload Payment Reciept</h4>
                        </div>
                        <div class="col-6 text-end">
                            <p class="card-title mb-0">Total Amount to be paid: <strong>ƒ {{$order->amount_converted}} ANG</strong></p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="javascript:void(0)" id="payment-update-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6 form-group">
                                <label>Payment Method</label>
                                <select class="form-control select2" id="payment_method" name="payment_method_id" style="width: 90%;">
                                    <!-- <option value="">--Select Payment--</option> -->
                                    @foreach($paymentMethods as $method)
                                        <option value="{{$method->id}}" {{$order->payment_id == $method->id ? 'selected': ''}}>{{$method->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Delivery Address</label>
                                <select class="form-control reciever_address select2" name="shipping_address_id" style="width: 90%;">
                                    @foreach($recieverAddresses as $recieverAddress)
                                    <option value="{{$recieverAddress->id}}" {{$order->shipping_address_id == $recieverAddress->id ? 'selected' : ''}}>{{$recieverAddress->first_name}} {{$recieverAddress->last_name}} - {{$recieverAddress->country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                            <label for="image">Payment Reciept</label>
                                @if(isset($order->payment_receipt))
                                    <div class="text-start p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset('storage/assets/payment')}}/{{$order->payment_receipt}}" width="100" height="100"/></div>
                                @endif
                                <div class="col-12" id="ni-payment-file-append">

                                </div> 
                            </div>

                            <div class="col-md-6">
                                <input type="file" id="ni-payment-file" class="form-control" name="payment_receipt">
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-stretch">
                            <button type="button" id="payment-update-btn" data-order-id="{{$order->id}}" class="btn btn-success">Save</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('footer-script')
<script>
    $('.select2').select2();
    $(document).on('click', "#payment-update-btn", function() {

        let id = $(this).data("order-id");
        let url = "{{route('purchasing.payment.update', ['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#payment-update-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, null, null)

    })
    
    $(document).on('change', "#payment_method", function() {
        let id = $(this).val();
        let user_id = {{$order->user_id}};
        let url = "{{route('purchasing.get.paymentInfo',['id' => ':id','user_id' => ':user_id'])}}";
        url = url.replace(':id', id);
        url = url.replace(':user_id', user_id);
        // Function to get html of Payment Data
        getHtmlAjax(url, null, "#payment_info")
    })

    $("#ni-payment-file").change(function() {
        filePreview(this);
    });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-exship-file-edit-preview').remove();

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

</script>
@endpush