<div class="row">
        <div class="col-12">
            <!-- Column -->
            <form class="form-horizontal" id="item-edit-form" action="javascript:void(0)">
                @csrf
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <div class="row">
                            <div class="col-6"> 
                                <h4 class="card-title mb-0">Update Item Parcel- #{{$parcel->invoice_no}}</h4>  
                            </div>
                            <div class="col-6 text-end">
                               
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
                                            @if($parcel->external_shipper_id == $val->id)
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
                                    <select name="parcel_status" id="ni-parcel-status" class="select2 form-control custom-select" style="width: 90%;">
                                        @foreach($parcelStatus as $status)
                                            <option value="{{$status->id}}" {{ $parcel->parcel_status_id == $status->id ? 'selected': '' }}>{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Invoice #</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcel->invoice_no ?? ''}}" name="invoice" id="ni-invoice" readonly>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <label>External AWB</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$parcel->external_waybill ?? ''}}" name="external_awb" id="ni-external-awb">
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
                                        <input type="text" class="form-control" value="{{$parcel->external_tracking ?? ''}}" name="tracking" id="ni-tracking">
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
                                        @foreach($paymentStatus as $status)
                                            @if($status->slug == 'paid' || $status->slug == 'unpaid')
                                                <option value="{{$status->id}}" {{ $parcel->payment_status_id == $status->id ? 'selected': '' }}>{{$status->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label>Payment Method</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <select name="payment_method" class="select2 form-control custom-select" style="width: 90%;" id="ni-payment-method">
                                        <option>Select Payment Method</option>
                                        @foreach($payments as $key => $val)  
                                            <option value="{{$key}}" {{ $parcel->payment_id == $key ? 'selected': '' }}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Delivery Date</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="delivery_date" value="{{$parcel->es_delivery_date ?? ''}}" id="ni-created-at" placeholder="mm/dd/yyyy">
                                        <span class="input-group-text">
                                            <i data-feather="calendar" class="feather-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($parcel->payment_receipt))
                                    <div class="text-start p-3 img-round"><img class="nl-exship-payment-edit-preview" src="{{asset('storage/assets/payment')}}/{{$parcel->payment_receipt}}" width="100" height="100"/></div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="row">
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
                        </div> -->
                    </div>
                    <div class="p-1 text-center">
                        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect"  data-parcel-id="{{$parcel->id}}" id="item-edit-button">Update Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script>
    // Select2 for form select fields
    $("#ni-courier").select2({
        templateResult: formatState,
        templateSelection: formatState
    });
    $("#ni-parcel-status").select2();
    $("#ni-payment-method").select2();
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

    $("#item-edit-button").on("click", function(e) {
        var id = $(this).data('parcel-id');
        let url = "{{route('purchasing.updateItemParcel', ['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#item-edit-form";
        let type = "POST";
        let ModalId = "#ni-add-item-parcel";
        createFormAjax( url , type , formId , ModalId , null )

    })

    $("#ni-payment-file").change(function() {
        filePreview(this);
    });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-exship-payment-edit-preview').remove();
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