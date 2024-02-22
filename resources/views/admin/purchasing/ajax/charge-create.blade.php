<form class="form-horizontal" id="billing-add-form" action="javascript:void(0)">
     @csrf
      
     <h3>Account Funds (<span id="wallet_amount">{{  number_format($total_wallet_amount*$currencyDollar,2)}}</span>  <span id="wallet_currency_code"> USD</span>)</h3>
     <input type="hidden" name="order_id" value="{{$order->id}}">
     <div class="row col-md-12">
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Tracking </label>
                 <input type="text" class="form-control" value="{{$order->tracking ?? ''}}" readonly>
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Customer</label>
                 <input type="text" class="form-control" value="{{$order->user->first_name ?? ''}} {{$order->user->last_name ?? ''}}" readonly>
             </div>
        </div>
     </div>

     <div class="row col-md-12">
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Total Amount </label>
                 <input type="number" class="form-control" value="{{$order->total ?? '0.00'}}" readonly>
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Balance Due</label>
                 <input type="text" class="form-control" value="{{$order->balance_due ?? '0.00'}}" readonly>
             </div>
        </div>
     </div>
     <div class="col-6 col-xs-12 col-sm-12 mb-4">
            <label><b>Currency</b></label>                 
            <div class="input-group mb-3">
                <select name="currency"  class="select2 form-control custom-select currency-select" style="width: 90%;">
              
                @if($currencies->count()>0)
                    @foreach($currencies as $key => $currency)
                        <option  value="{{$currency->id}}">{{$currency->name}}</option>
                    @endforeach
                @endif
                </select>
            </div>                    
      </div>
     <div class="row col-md-12">
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Total to pay </label>
                 <input type="number" name="paid_amount" class="form-control" value="" steps="0.01">
             </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                 <label>Payment Method</label>
                 <select class="form-control select2" id="payment_method" name="payment_method" style="width: 90%;">
                    <option value="">--Select Payment Method--</option>
                    @foreach($payments as $key => $val)
                        <option value="{{$key}}">{{$val}}</option>
                    @endforeach
                 </select>
             </div>
        </div>
     </div>

     <div class="mt-3 row payment-row">
        <div class="col-md-6">
            <label for="image">Payment Reciept</label>
            <input type="file" id="ni-payment-file" class="form-control" name="payment_receipt">
        </div>
        <div class="col-md-6">
            <div class="col-12" id="ni-payment-file-append">

            </div> 
        </div>


    </div>
     
     <div class="mt-5 text-end">
         <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="billing-add-button">Save</button>
     </div>
 </form>

 <script type="text/javascript">
       
    
      $(document).ready(function(){
        var collection = @json($currenciesData);
        
        $('.currency-select').on('change',function(){
            var wallet_amount='';
            var id = $(this).val();
            var account_funds= '{{$total_wallet_amount}}';
       
            var filteredNumbers = $.grep(collection, function (value) {
                
            return value.id==id;
            //% 2 === 0 
            // Filter even numbers
            });
            wallet_amount= $('#wallet_amount').text();
           
            var amount_curr=   account_funds*filteredNumbers[0].value;    
            var formattedNum = amount_curr.toFixed(2);
          
            $('#wallet_amount').text(formattedNum);
            $('#wallet_currency_code').text(filteredNumbers[0].code);
            

            //console.log(filteredNumbers[0] );
        });
        
      });
     $("#ni-payment-file").change(function() {
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