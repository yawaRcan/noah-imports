<div class="row">
    <div class="col-12">
         
      
       
       @if($payment->payment_receipt!=null ||  $payment->payment_receipt!='')
       
        @php 
          $extension = pathinfo($payment->payment_receipt, PATHINFO_EXTENSION);
        @endphp
        @if($extension=='pdf')
        {{-- route('download-pdf') --}}
         <a href="{{asset('storage/assets/payment')}}/{{$payment->payment_receipt}}" class="btn btn-primary">Download PDF</a>

        @endif
       <img src="{{asset('storage/assets/payment')}}/{{$payment->payment_receipt}}" class="img-fluid" alt="">
       @else
       <h3>No Payment Receipt Found<h3>
       @endif
    </div>
</div>

<script>
</script>