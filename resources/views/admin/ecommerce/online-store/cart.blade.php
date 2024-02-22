@if(count($carts) > 0)
<!-- -------------------------------------------------------------- -->
<!-- Start Cart Content -->
<!-- -------------------------------------------------------------- -->
<div class="row">
    <!-- Column -->
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <!-- <div class="card-header bg-info">
                                            <h5 class="mb-0 text-white">Your Cart (4 items)</h5>
                                        </div> -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table product-overview">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Title</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th style="text-align:center">Total</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $key => $cart)
                            <tr>
                                <td><img src="{{asset('storage/assets/product')}}/{{$cart->product->files[0]->hash_name}}" alt="iMac" width="50"></td>
                                <td>
                                    <h5 class="font-500">{{$cart->product->title}}</h5>
                                    <!-- <p>Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look</p> -->
                                </td>
                                <td>${{$cart->price}}</td>
                                <td>
                                    <input type="number" class="form-control" value="{{$cart->quantity}}">
                                </td>
                                <td align="center" class="font-500">${{$cart->price * $cart->quantity}}</td>
                                <td align="center"><a href="javascript:void(0)" class="text-inverse cart-data-delete" data-cart-id="{{$cart->id}}" title="" data-bs-toggle="tooltip" data-original-title="Delete"><i class="mdi mdi-delete"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- <div class="d-flex no-block align-items-center">
                        <button class="btn btn-dark btn-outline"><i data-feather="arrow-left" class="fill-white feather-sm"></i> Continue shopping</button>
                        <div class="ms-auto">
                            <button class="btn btn-danger"><i data-feather="shopping-cart" class="fill-white feather-sm"></i> Checkout</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <form class="form-horizontal" id="checkout-form" action="javascript:void(0)">
        <div class="row col-md-12">
            <div class="col-md-6">
                <label>Reciever Address</label>
                <select class="form-control reciever_address select2" name="shipping_address_id" style="width: 90%;">
                    @if(isset($carts[0]->user->shipping))
                    @foreach($carts[0]->user->shipping as $recieverAddress)
                    <option value="{{$recieverAddress->id}}">{{$recieverAddress->first_name}} {{$recieverAddress->last_name}} - {{$recieverAddress->country->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label>Payment Method</label>
                <select class="form-control payment_method select2" name="payment_method_id" style="width: 90%;">
                    <option value="">--Select Payment--</option>
                    @foreach($paymentMethods as $method)
                    <option value="{{$method->id}}">{{$method->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{ $carts[0]->user_id ?? '' }}">
        <input type="hidden" name="currency_id" value="{{ $carts[0]->currency_id ?? '' }}">
        <input type="hidden" name="subtotal" value="{{ $calc['total'] ?? '' }}">
        <input type="hidden" name="total" value="{{ $calc['tenOrderFee'] ?? '' }}">
        <input type="hidden" name="total_converted" id="ni-total-converted" value="{{ $calc['totalConverted'] ?? '' }}">
        <div class="row col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">CART SUMMARY</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-start"><strong>Shipping Price</strong></p>
                            <span class="text-end">${{$calc['shipping']}}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="text-start"><strong>Tax</strong></p>
                            <span class="text-end">${{$calc['tax']}}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="text-start"><strong>Item Price</strong></p>
                            <span class="text-end">${{$calc['total']}}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-start"><strong>10% Order Fee</strong></p>
                            <span class="text-end">${{$calc['tenOrderFee']}}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="text-start"><strong>Paypal Fee ( % )</strong></p>
                            <span class="text-end">${{$calc['paypal']}}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="text-start"><strong>Item Price & Administration Fee & Paypal</strong></p>
                            <span class="text-end">${{$calc['adminFee']}}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-start"><strong>Total Converted</strong></p>
                            <span class="text-end" id="ni-total-converted-start">ƒ <span id="ni-total-converted-data"> {{$calc['totalConverted']}} </span> ANG</span>
                            <span class="text-end text-success" id="ni-total-converted-coupon"></span>
                        </div>
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-3">
                            <p class="text-start"><input type="text" class="form-control" id="ni-coupon-code" placeholder="Coupon Code"></p>
                            <div class="text-start"><a href="javascript:void(0)" class="btn btn-success btn-flat form-control" id="ni-coupon-apply">Apply Coupon</a></div>
                        </div>
                    </div>
                    <hr>
                    <div class="p-3 border-top">
                        <div class="text-end">
                            <button class="btn btn-danger rounded-pill px-4 waves-effect waves-light" id="checkout-button">Checkout</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- <div class="card">
                <div class="card-body">
                    <h5 class="card-title">For Any Support</h5>
                    <hr>
                    <h4><i class="ti-mobile"></i> 9998979695 (Toll Free)</h4> <small>Please contact with us if you have any questions. We are avalible 24h.</small>
                </div>
            </div> -->
        </div>
    </form>
</div>
<!-- -------------------------------------------------------------- -->
<!-- End Cart Content -->
<!-- -------------------------------------------------------------- -->
@else
<!-- empty cart -->
<div class="text-center">
    <img src="https://noah.test/assets/images/icon/empty-cart.png" style="width: 100px;">
    <p style="text-align: center;">Your cart is empty</p>
</div>

@endif

<script>
    $(document).on('click', '#ni-coupon-apply', function(e) {

        var value = $('#ni-coupon-code').val();

        if (value != null && value != '' && value != 'undefined') {

            let url = "{{route('online-store.coupon-apply')}}?code=" + value + "&totalConverted=" + $('#ni-total-converted-data').text();
            let type = "POST";
            var coupon = createFormAjax(url, type); 
            setTimeout(function() {
                if ("responseJSON" in coupon && "error" in coupon.responseJSON) {
                    // The property 'responseJSON' exists in 'obj' and it has the property 'error'
                    // 
                    console.log(coupon.responseJSON.error); // Output: "Coupon Code Does Not Exist"
                } else {
                    // Either 'responseJSON' or 'error' property is missing
                    $('#ni-total-converted-start').addClass('text-decoration-line-through text-danger')
                    var text = "ƒ " + $('#ni-total-converted-coupon').text() + " ANG";
                    $('#ni-total-converted').val($('#ni-total-converted-coupon').text());
                }

            }, 2000);
        }

    })
</script>