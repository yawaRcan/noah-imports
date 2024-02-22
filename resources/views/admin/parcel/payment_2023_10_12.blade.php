<form id="payment-form" action="javascript:void(0)" enctype="multipart/form-data">
    

    <div class="row">
        <div class="col-12">
            <input type="hidden" name="id" value="{{$payment->id}}">
            @if($payment->invoice_payment_receipt)
            <img src="{{asset('storage/assets/payment')}}/{{$payment->invoice_payment_receipt}}" style="width: 100%;" class="img-fluid mx-auto d-block" alt="">
            @else
            <label>Upload File</label>
            <input type="file" id="ni-payment-file" class="form-control" name="payment_receipt">
            <div class="col-12" id="ni-payment-file-append">

            </div>
            <label class="mt-3">Payment Method</label>
            <select name="payment_method" class="form-control" id="payment_method">
                @foreach($payments as $key => $val)
                    <option value="{{$key}}" {{ $payment->payment_id == $key ? 'selected': '' }}>{{$val}}</option>
                @endforeach
            </select>
            @endif 
            <br><br>
            <label>Payment Status</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="mdi mdi-webhook"></span>
                    </span>
                    <select name="payment_status" class="form-control" id="payment_status">
                        @foreach($paymentStatuses as $status)
                            @if($status->slug == 'paid' || $status->slug == 'unpaid')
                                <option value="{{$status->id}}" {{ $payment->payment_status_id == $status->id ? 'selected': '' }}>{{$status->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                 <div class="col-12 mt-3 text-end">
                <a href="javascript:void(0)" class="btn btn-success btn-flat" id="update-payment"> Update</a>
            </div>
        </div>
       
    </div>

</form>

<script> 

    $("#update-payment").on('click', function(e) {
        e.stopPropagation();
        let url = "{{route('parcel.paymentStatus.update')}}";
        let ModalId = "#ni-payment-change-modal";
        let formId = "#payment-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, table) 
    })

    $("#ni-payment-file").change(function() {
        filePreview(this);
    });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // $('.nl-exship-file-edit-preview').remove();

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