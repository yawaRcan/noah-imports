<form class="form-horizontal" id="billing-edit-form" action="javascript:void(0)">
     @csrf
     <div class="row col-md-12">
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Tracking </label>
                 <input type="text" class="form-control" value="{{$charge->order->tracking ?? ''}}" readonly>
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Customer</label>
                 <input type="text" class="form-control" value="{{$charge->order->user->first_name ?? ''}} {{$charge->order->user->last_name ?? ''}}" readonly>
             </div>
        </div>
     </div>

     <div class="row col-md-12">
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Total Amount </label>
                 <input type="number" class="form-control" value="{{$charge->order->total ?? '0.00'}}" readonly>
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Balance Due</label>
                 <input type="text" class="form-control" value="{{$charge->order->balance_due ?? '0.00'}}" readonly>
             </div>
        </div>
     </div>

     <div class="row col-md-12">
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Total to pay </label>
                 <input type="number" name="paid_amount" class="form-control" value="{{$charge->paid_amount}}" steps="0.01">
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Payment Method</label>
                 <select class="form-control select2" id="payment_method" name="payment_method" style="width: 90%;">
                    @foreach($payments as $key => $val)
                        <option value="{{$key}}" {{$charge->payment_id == $key ? 'selected' : ''}}>{{$val}}</option>
                    @endforeach
                 </select>
             </div>
        </div>
     </div>

     <div class="mt-3 row payment-row">
        <div class="col-md-6">
            <label for="image">Payment Reciept</label>
            <input type="file" id="ni-payment-edit-file" class="form-control" name="payment_receipt">
        </div>
        <div class="col-md-6">
        
            @if(isset($charge->payment_invoice))
                <div class="text-start p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset('storage/assets/payment')}}/{{$charge->payment_invoice}}" width="100" height="100"/></div>
            @endif
            <div class="col-12" id="ni-payment-edit-file-append">

            </div> 
        </div>


    </div>
     
     <div class="mt-5 text-end">
         <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="billing-edit-button" data-billing-id="{{$charge->id}}">Update</button>
     </div>
 </form>

  <script type="text/javascript">
     
     $("#ni-payment-edit-file").change(function() {
        filePreview(this);
    });

     $('#payment_method').change(function() {
        var id = $(this).val();
        if(id == 4)
            $('.payment-row').hide();
        else
            $('.payment-row').show();
     });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-exship-file-edit-preview').remove();

                if (input.files[0].type.indexOf('image') === 0) {
                  // If it's an image, display it in the file preview
                  $('#ni-payment-edit-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                } else {
                  // If it's not an image, display the document icon
                  $('#ni-payment-edit-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                }

            };
            reader.readAsDataURL(input.files[0]);
        }
    }
 </script>