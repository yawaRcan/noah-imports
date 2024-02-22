@extends('user.layout.master')

@section('content')
<link href="{{asset('assets/libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Online Store</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('product.index')}}">Ecommerce</a></li>
            <li class="breadcrumb-item active">Online Store</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>THIS MONTH</small></h6>
                    <h4 class="mt-0 text-info">ƒ {{$cm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>LAST MONTH</small></h6>
                    <h4 class="mt-0 text-primary">ƒ {{$lm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills nav-fill mt-4 justify-content-center" role="tablist">
                            <li class="nav-item bg-primary m-2 shadow card-hover">
                                <a class="nav-link active" data-bs-toggle="tab" href="#navpill-111" role="tab">
                                    <span class="text-white">Shop Now</span>
                                </a>
                            </li>
                            <li class="nav-item bg-primary m-2 shadow card-hover">
                                <a class="nav-link" data-bs-toggle="tab" href="#navpill-222" role="tab">
                                    <span class="text-white">Cart (0)</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                    </div>
                </div>
                <div class="card-body">

                    <div class="tab-content border mt-2">
                        <div class="tab-pane active p-3" id="navpill-111" role="tabpanel">
                            <div class="row">
                                <!-- -------------------------------------------------------------- -->
                                <!-- Product  Content -->
                                <!-- -------------------------------------------------------------- -->
                                <div class="row el-element-overlay">
                                    @forelse($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="card card-hover shadow">
                                            <div class="el-card-item pb-3">
                                                <div class="el-card-avatar mb-3 el-overlay-1 w-100 overflow-hidden position-relative text-center"> <img src="{{asset('storage/assets/product/')}}/{{$product->files[0]->hash_name}}" class="d-block position-relative w-100" alt="user" />
                                                    <div class="el-overlay w-100 overflow-hidden">
                                                        <ul class="list-style-none el-info text-white text-uppercase d-inline-block p-0">
                                                            <li class="el-item d-inline-block my-0  mx-1"><a class="btn default btn-outline image-popup-vertical-fit el-link text-white border-white" href="{{asset('storage/assets/product/')}}/{{$product->files[0]->hash_name}}"><i class="icon-magnifier"></i></a></li>
                                                            <li class="el-item d-inline-block my-0  mx-1"><a class="btn default btn-outline el-link text-white border-white add-to-cart" href="javascript:void(0);" data-product-id='{{$product->id}}'><i class="mdi mdi-cart"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="ms-3">
                                                        <h4 class="mb-0"><a href="javascript:void(0)" class="show-product-detail" data-product-id="{{$product->id}}">{{$product->title}}</a></h4>
                                                        <span class="text-muted">{{$product->category->title}} - {{$product->subCategory->title}}</span>
                                                    </div>
                                                    <div class="ms-auto me-3">
                                                        <button type="button" class="btn btn-dark btn-circle">${{$product->price}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center">
                                        Products is not available
                                    </div>
                                    @endforelse
                                </div>
                                <!-- -------------------------------------------------------------- -->
                                <!-- End Product Content -->
                                <!-- -------------------------------------------------------------- -->
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="navpill-222" role="tabpanel">
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
                                                <option value="{{$recieverAddress->id}}">{{$recieverAddress->name}} - {{$recieverAddress->country->name}}</option>
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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add modal content -->
<div class="modal fade" id="ni-product-detail-modal" tabindex="-1" aria-labelledby="ni-product-detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Product Detail</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-product-detail-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


@endsection

@push('footer-script')
<script src="{{asset('assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/libs/magnific-popup/meg.init.js')}}"></script>

<script>
    $(document).on('click', '.add-to-cart', function(e) {

        let id = $(this).data('product-id');
        let user_id = $('#ni-search_id').val();
        let url = "{{route('user.online-store.add-to-cart',['id' => ':id','user_id' => ':user_id'])}}";
        url = url.replace(':id', id);
        url = url.replace(':user_id', user_id);
        let type = "POST";
        createFormAjax(url, type)

    });

    $(document).on('click', ".cart-data-delete", function() {
        let id = $(this).data("cart-id");
        let url = "{{route('user.online-store.cart-delete',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url)
    })

    $(document).on('click', ".show-product-detail", function() {
        let id = $(this).data("product-id");
        let url = "{{route('user.online-store.show',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-product-detail-modal", "#ni-product-detail-body")
    })

    $(document).on('click', "#checkout-button", function() {

        // Collecting Current Form Data 
        let formId = "#checkout-form";

        let url = "{{route('user.ec-order.store')}}";
        let type = "POST";
        createFormAjax(url, type, formId)


    });

    $(document).on('click', '#ni-coupon-apply', function(e) {

            var value = $('#ni-coupon-code').val();

            if (value != null && value != '' && value != 'undefined') {

                let url = "{{route('user.online-store.coupon-apply')}}?code="+value+"&totalConverted="+$('#ni-total-converted-data').text();  
                let type = "POST";
                createFormAjax( url , type );
                $('#ni-total-converted-start').addClass('text-decoration-line-through text-danger')
                setTimeout(function() { 
                    var text = "ƒ "+$('#ni-total-converted-coupon').text()+" ANG"; 
                    $('#ni-total-converted').val($('#ni-total-converted-coupon').text())
                    }, 2000);  
            }

})
</script>
@endpush