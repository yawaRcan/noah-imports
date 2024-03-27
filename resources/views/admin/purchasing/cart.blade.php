@if(isset($cartData[0]) && !is_null($cartData))
@foreach($cartData as $details)
<input type="hidden" name="purchase_id[]" value="{{ $details->purchase_id }}">
<tr data-id="{{ $details->purchase_id }}">
    <td>{{ $details->purchase->name ?? 'N/A' }}</td>
    <td>{{ $details->purchase->description ?? 'N/A' }}</td>
    <td>{{ $details->purchase->quantity }}</td>
    <td>{{ $details->purchase->currency->symbol }} {{ $details->purchase->price }}</td>
    <td><button class="btn btn-primary btn-sm edit-cart"><i class="fa fa-edit"></i></button>&nbsp;<button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $details->purchase_id }}"><i class="fa fa-trash"></i></button></td>
</tr>
@endforeach
<input type="hidden" name="user_id" value="{{ $cartData[0]->user_id ?? '' }}">
<input type="hidden" name="currency_id" value="{{ $cartData[0]->purchase->currency_id ?? '' }}">
<tr>
    <td>
        <a href="javascript:void(0)" class="btn btn-primary btn-rounded ni-create-new-item"><i class="mdi mdi-plus"></i></a>
    </td>
    <td colspan="2"><strong>Create Discount</strong></td>
    <td class="text-right">
        <div class="form-check">
            <input class="form-check-input" name="discount" type="checkbox" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Apply Discount
            </label><br>
            -0%
        </div>
    </td>
</tr>

<tr>
    <td colspan="3"><strong>Select Address</strong></td>
    <td class="text-right">
        <select class="form-control reciever_address" name="shipping_address_id">
            @foreach($cartData[0]->user->shipping as $recieverAddress)
            <option value="{{$recieverAddress->id}}">{{$recieverAddress->first_name}} {{$recieverAddress->last_name}} - {{$recieverAddress->country->name}}</option>
            @endforeach
        </select>
    </td>
</tr>
<!-- <tr>
    <td colspan="3"><strong>Payment Method</strong></td>
    <td class="text-right">
        <select class="form-control payment_method" name="payment_method_id">
            <option value="">--Select Payment--</option>
            @foreach($paymentMethods as $method)
            <option value="{{$method->id}}">{{$method->name}}</option>
            @endforeach
        </select>
    </td>
</tr> -->
<input type="hidden" name="subtotal" value="{{$cal->total}}">
<input type="hidden" name="shipping_price" value="{{$cal->shipping ?? '00.0'}}">
<input type="hidden" name="tax" value="{{$cal->tax ?? '00.0'}}">
<tr>
    <td colspan="3"><strong>Shipping Price</strong></td>
    <td class="text-right">
        <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->shipping ?? '00.0'}}</strong>
    </td>
</tr>
<tr>
    <td colspan="3"><strong>Tax</strong></td>
    <td class="text-right">
        <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->tax ?? '00.0'}}</strong>
    </td>
</tr>
<tr>
    <td colspan="3"><strong>Item Price</strong></td>
    <td class="text-right">
        <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->total ?? '00.0'}}</strong>
    </td>
</tr>
<tr>
    <td colspan="3"><strong>Paypal Fee ( % )</strong></td>
    <td class="text-right">
        <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->paypal ?? '00.0'}}</strong>
    </td>
</tr>
<tr>
    <td colspan="3"><strong>Item Price & Administration Fee & Paypal</strong></td>
    <td class="text-right">
        <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->adminFee ?? '00.0'}}</strong>
    </td>
</tr>
<input type="hidden" name="eGaroshiTax" value="{{$adminFee ?? '00.0'}}">

<input type="hidden" name="total" value="{{$cal->tenOrderFee?? '00.0'}}">
<tr>
    <td colspan="3"><strong>10% Order Fee</strong></td>
    <td class="text-right">
        <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->tenOrderFee ?? '00.0'}}</strong>
    </td>
</tr>
<input type="hidden" name="converted_amount" value="{{$cal->totalConverted ?? '00.0'}}">
<tr>
    <td colspan="3"><strong>Total Converted</strong></td>
    <td class="text-right">
        <strong>ƒ {{$cal->totalConverted ?? '00.0'}} ANG </strong>
    </td>
</tr>
@else
<tr>
    <td colspan="4" style="text-align: center;">
        <!-- empty cart -->
        <img src="{{asset('assets/images/icon/empty-cart.png')}}" style="width: 100px;">
        <p style="text-align: center;">Your cart is empty</p>
    </td>
</tr>
@endif