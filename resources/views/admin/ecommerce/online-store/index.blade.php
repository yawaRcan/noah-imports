@extends('admin.layout.master')

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
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <select class="form-control custom-select" id="ni-search_id" name="search_user_id" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <a href="#" id="ni-user-spin" style="font-size: 25px;" class="hide">
                                            <div class="spinner-border spinner-border-sm mb-3" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </a>
                                        <a href="#" class="mdi-check-btn hide" style="font-size: 20px;">
                                            <span class="mdi mdi-check-circle"></span>
                                        </a>
                                        <a href="#" class="mdi-cross-btn hide text-danger" style="font-size: 20px;">
                                            <span class="mdi mdi-account-off"></span>
                                        </a>
                                        <span class="text-danger reciver-error-text"></span>

                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="ni-search-input" placeholder="Search">
                                        <div class="input-group-append">
                                            <a class="btn btn-outline-secondary" href="javascript:void(0)" id="ni-search-btn">
                                                <i class="mdi mdi-search-web"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- -------------------------------------------------------------- -->
                                <!-- Product  Content -->
                                <!-- -------------------------------------------------------------- -->
                                <div class="row el-element-overlay" id="ni-product-search">
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
                                                        <button type="button" class="btn btn-lg btn-dark rounded-circle">${{$product->price}}</button>
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
                                <div class="col-md-9 col-lg-9">
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
                                                            <td width="150"><img src="{{asset('storage/assets/product')}}/{{$cart->product->files[0]->hash_name}}" alt="iMac" width="50"></td>
                                                            <td width="550">
                                                                <h5 class="font-500">{{$cart->product->title}}</h5>
                                                                <!-- <p>Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look</p> -->
                                                            </td>
                                                            <td>${{$cart->price}}</td>
                                                            <td width="70">
                                                                <input type="number" class="form-control" value="{{$cart->quantity}}">
                                                            </td>
                                                            <td width="150" align="center" class="font-500">${{$cart->price * $cart->quantity}}</td>
                                                            <td align="center"><a href="javascript:void(0)" class="text-inverse cart-data-delete" data-cart-id="{{$cart->id}}" title="" data-bs-toggle="tooltip" data-original-title="Delete"><i class="mdi mdi-delete"></i></a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <div class="d-flex no-block align-items-center">
                                                    <button class="btn btn-dark btn-outline"><i data-feather="arrow-left" class="fill-white feather-sm"></i> Continue shopping</button>
                                                    <div class="ms-auto">
                                                        <button class="btn btn-danger"><i data-feather="shopping-cart" class="fill-white feather-sm"></i> Checkout</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <div class="col-md-3 col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">CART SUMMARY</h5>
                                            <hr>
                                            <small>Total Price</small>
                                            <h2>$612</h2>
                                            <hr>
                                            <a class="btn btn-success w-100 mb-1">Checkout</a>
                                            <a class="btn btn-secondary w-100 btn-outline">Cancel</a>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">For Any Support</h5>
                                            <hr>
                                            <h4><i class="ti-mobile"></i> 9998979695 (Toll Free)</h4> <small>Please contact with us if you have any questions. We are avalible 24h.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                            <!-- End Cart Content -->
                            <!-- -------------------------------------------------------------- -->
                            @else
                            <!-- empty cart -->
                            <div class="text-center">
                                <img src="{{asset('assets/images/icon/empty-cart.png')}}" style="width: 100px;">
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
        let url = "{{route('online-store.add-to-cart',['id' => ':id','user_id' => ':user_id'])}}";
        url = url.replace(':id', id);
        url = url.replace(':user_id', user_id);
        let type = "POST";
        createFormAjax(url, type)

    });

    $(document).on('click', ".cart-data-delete", function() {
        let id = $(this).data("cart-id");
        let url = "{{route('online-store.cart-delete',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url)
    })

    // Searching Users From the User select field
    $("#ni-search_id").select2({
        placeholder: "Select a user",
        allowClear: true,
        ajax: {
            url: "{{route('parcel.getusers')}}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                $('.reciver-error-text').html('')
                $('.mdi-check-btn').addClass('hide');
                $('.mdi-cross-btn').addClass('hide');
                $('#ni-user-spin').removeClass('hide');
                return {
                    q: params.term, // search term 
                };
            },
            processResults: function(data) {
                // Appending Data to User select Field
                var arr = []
                $.each(data.items, function(index, value) {
                    arr.push({
                        id: value.id,
                        text: value.first_name + ' ' + value.last_name
                    })
                });
                $('#ni-user-spin').addClass('hide');
                return {
                    results: arr
                };
            },
            cache: true,
        },
        minimumInputLength: 1
    });

    // Ajax Action of checking Selected User Addresses 
    $(document).on('change', "#ni-search_id", function() {

        let id = $(this).val();
        if (id != "undefined" && id != null && id != '') {
            var request = $.ajax({
                url: "{{route('online-store.cartHtml')}}",
                method: "GET",
                dataType: "json",
                data: {
                    id: id
                },
            });
            // Done Action of checking Selected User Addresses 
            request.done(function(response) {

                if (response.html) {
                    $('#' + response.html.selector).html(response.html.data)
                }

            });
            // Fail Action of checking Selected User Addresses 
            request.fail(function(jqXHR, textStatus) {

                if (jqXHR.status) {
                    notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
                }
            });
        }
    })

    $(document).on('click', ".show-product-detail", function() {
        let id = $(this).data("product-id");
        let url = "{{route('online-store.show',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-product-detail-modal", "#ni-product-detail-body")
    })

    $(document).on('click', "#checkout-button", function() {

        // Collecting Current Form Data 
        let formId = "#checkout-form";

        let url = "{{route('ec-order.store')}}";
        let type = "POST";
        createFormAjax(url, type, formId)

    });

    $(document).on('click', "#ni-search-btn", function() {
        $("#ni-product-search").html('')
        var value = $('#ni-search-input').val();
        let url = "{{route('online-store.search')}}/?search=" + value;
        let type = 'GET';
        createFormAjax(url, type)
    })
</script>
@endpush