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
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0"><b class="text-danger">Shipment Tracking</b> <b>| #{{$parcel->waybill ?? 'N/A'}}</b></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="javascript:void(0)" id="deliver-shipment-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6 form-group">
                                <label>Delivery Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="delivery_date" value="{{$delivery->delivery_date ?? ''}}" id="ni-estimate-delivery-date" placeholder="mm/dd/yyyy">
                                    <span class="input-group-text">
                                        <i data-feather="calendar" class="feather-sm"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Delivered By</label>
                                <select class="form-control select2" name="delivered_by" style="width: 90%;">
                                    <option>--Select --</option>
                                    @foreach($senderAddresses as $sender)
                                        <option value="{{$sender->id}}" {{$sender->id == @$delivery->admin_id ? 'selected' : ''}}>{{$sender->first_name}} {{$sender->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">

                            <div class="col-md-6">
                                <label>Person who recieves</label>
                                <input type="text" id="reciever-name" class="form-control" name="reciever_name" placeholder="Name who recieves the package" value="{{$delivery->reciever_name ?? ''}}">
                            </div>

                            <div class="col-md-6">
                                <label for="image">Upload file or Take photo</label>
                                @if(isset($delivery->parcel_image))
                                    <div class="text-start p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset('storage/assets/parcelDelivery')}}/{{$delivery->parcel_image}}" width="100" height="100"/></div>
                                @endif
                                <input type="file" id="ni-parcel-file" class="form-control" name="parcel_image" accept="image/*" style="width:90%">
                                <div class="col-12" id="ni-parcel-file-append">

                                </div> 
                            </div>
                        </div>

                        <div class="mt-4 row">

                            <div class="col-md-6">
                                <label>Draw your signature with your mouse</label><br>
                                <button type="button" id="signature_btn" class="btn btn-primary">
                                  Open signature
                                </button>
                                <input type="hidden" id="sign_image" name="sign_image" value="{{$delivery->signature ?? ''}}">
                                <span id="signature_image">
                                    @if(isset($delivery->signature))
                                        <div class="text-start p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset('storage/assets/signatures')}}/{{$delivery->signature}}" width="100" height="100"/></div>
                                    @endif
                                </span>
                            </div>

                            <div class="col-md-6">
                            </div>
                        </div>
                        
                        <div class="mt-3" align="right">
                            <button type="button" class="btn btn-secondary">Back Dashboard Status</button>
                            <button type="button" id="deliver-shipment-btn" data-parcel-id="{{$parcel->id}}" class="btn btn-success">Deliver Shipment</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add modal content -->
<div class="modal fade" id="ni-signature-modal" tabindex="-1" aria-labelledby="ni-signature-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Draw your signature with your mouse</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-signature-modal-body">
                <div id="signature-pad" class="border border-primary" style="width:50%;">
                  <canvas></canvas>
                </div>
                <button id="clear-button" class="btn btn-warning mt-3">Clear Signature</button>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-signature" class="btn btn-primary" data-parcel-id="{{$parcel->id}}">Save Signature</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


@endsection

@push('footer-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.select2').select2();

    $("#ni-parcel-file").change(function() {
        filePreview(this);
    });

    var currentDate = new Date();
    jQuery('#ni-estimate-delivery-date').datepicker({
        autoclose: true,
        todayHighlight: true,
    }).datepicker('setDate', currentDate);

    // Get the canvas element and create a SignaturePad instance
    var canvas = document.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas);

    // Get the clear button element
    var clearButton = document.getElementById("clear-button");

    // Clear the signature pad when the clear button is clicked
    clearButton.addEventListener("click", function () {
      signaturePad.clear();
    });

    $('#signature_btn').click(function(){
        signaturePad.clear();
        $('#ni-signature-modal').modal('show');
    })


    $('#save-signature').on('click', function(e) {
        e.stopPropagation();

        if (signaturePad.isEmpty()) {
            alert("Please provide a signature.");
            return;
          }
        let id = $(this).data("parcel-id");
        var signatureData = signaturePad.toDataURL();

         $.ajax({
            url: "{{route('parcel.signature.save')}}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: {
                id: id, 
                signature: signatureData 
            },
            success: function (response) {
              if (response.success) {
                notify('success', response.success);
                $('#ni-signature-modal').modal('hide');
                $('#signature_image').html('<div class="text-start p-3 img-round"><img class="nl-exship-sign-add-preview" src="{{asset("storage/assets/signatures")}}/' + response.imageName + '" width="100" height="100"/></div>');
                $('#sign_image').val(response.imageName);
              }
            }
          });

    })

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-exship-file-edit-preview').remove();
                if (input.files[0].type.indexOf('image') === 0) {
                  // If it's an image, display it in the file preview
                  $('#ni-parcel-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                } else {
                  // If it's not an image, display the document icon
                  $('#ni-parcel-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on('click', "#deliver-shipment-btn", function() {

        let id = $(this).data("parcel-id");
        let url = "{{route('parcel.deliver.shipment', ['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#deliver-shipment-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, null, null)

    })

</script>
@endpush