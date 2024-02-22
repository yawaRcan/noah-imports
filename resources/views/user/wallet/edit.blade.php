<form class="form-horizontal" id="wallet-edit-form" action="javascript:void(0)"> 
    @csrf 
    
                        <div class="mb-3">
                            <label for="image">Payment Method</label>
                            <select class="form-control payment_method" name="payment_method">
                                <option value="">--Select Payment Method--</option>
                                @foreach($paymentMethods as $key => $val)
                                <option value="{{$key}}" {{$wallet->payment_id == $key ? 'selected': ''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="mb-3">
                            <label for="image">Currency</label>
                            <select class="form-control" name="currency">
                                <option value="">--Select Currency--</option>
                                @foreach($currencies as $currency)
                                <option value="{{$currency->id}}" {{$wallet->currency_id == $currency->id ? 'selected': ''}}>{{$currency->name}}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="mb-3">
                             <label>Amount </label>
                             <input type="number" class="form-control" value="{{$wallet->amount}}" name="deposit_amount" placeholder="Enter Amount">
                         </div>
                         
                         <div class="mb-3">
                            <div class="col-md-6">
                                <label for="image">Payment Reciept</label>
                                <input type="file" id="ni-payment-file" class="form-control" name="payment_receipt" accept="image/*">
                            </div>
                            <div class="col-md-6" id="ni-payment-file-append">
                            </div>
                         </div>

                         
                         <div class="mb-3">
                             <label>Description</label>
                             <textarea rows="5" cols="5" name="deposit_desc" class="form-control"> {{$wallet->description}}</textarea>
                         </div>
    {{-- 
    <div class="mb-3">
        <label>Gender</label>
         <select name="gender" class="form-control" id="gender_id" disabled>
          <option value="">Select Gender</option>
          <option value="0" {{$User->gender == 0 ? 'selected': ''}}>Male</option>
          <option value="1" {{$User->gender == 1 ? 'selected': ''}}>Female</option>
      </select>
    </div>
   
    --}}
    <div class=" text-end">
        <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="wallet-edit-button" data-wallet-id="{{$wallet->id}}">Update</button>
    </div>
</form>