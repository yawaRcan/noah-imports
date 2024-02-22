<div class="row">
        <div class="col-12">
          
        
        <input type="hidden" name="id" value="{{$payment->id}}">
            @if($payment->payment_receipt)
          
            <img src="{{asset('storage/assets/payment')}}/{{$payment->payment_receipt}}" style="width: 100%;" class="img-fluid mx-auto d-block" alt="">
            @else
             <h6>No Order Invoice Is Exist ! {{$payment->payment_receipt}}</h6>
            @endif 
        
    </div>
</div>    
