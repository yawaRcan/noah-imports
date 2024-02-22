<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <label for="image">Payment Method</label>
            <select disabled class="form-control payment_method" name="payment_method">
                <option value="">--Select Payment Method--</option>
                @foreach($paymentMethods as $key => $val)
                <option disabled value="{{$key}}" <?php echo ($key==$parcel->payment_id)?'selected': '' ?>>{{$val}} </option>
                @endforeach
            </select>
        </div>
       
       @if($parcel->invoice_payment_receipt!=null ||  $parcel->invoice_payment_receipt!='')
       <img src="{{asset('storage/assets/payment')}}/{{$parcel->invoice_payment_receipt}}" class="img-fluid" alt="">
       @else
       <h3>No Payment Receipt Found<h3>
       @endif
    </div>
</div>

<script>
</script>