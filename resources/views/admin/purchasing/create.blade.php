@extends('admin.layout.master')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/dropzone/dist/min/dropzone.min.css')}}">
<style>
    .wrapper {
        text-transform: uppercase;
        /* background: #ececec; */
        color: #555;
        cursor: help;
        font-family: "Gill Sans", Impact, sans-serif;
        font-size: 15px;
        /* margin: 100px 75px 10px 75px; */
        /* padding: 15px 20px; */
        position: relative;
        text-align: right;
        /* width: 200px; */
        -webkit-transform: translateZ(0);
        /* webkit flicker fix */
        -webkit-font-smoothing: antialiased;
        /* webkit text rendering fix */
    }

    .wrapper .tooltip {
        background: #1496bb;
        bottom: 100%;
        color: #fff;
        display: block;
        left: 0px;
        margin-bottom: 15px;
        opacity: 0;
        padding: 20px;
        pointer-events: none;
        position: absolute;
        width: 100%;
        -webkit-transform: translateY(10px);
        -moz-transform: translateY(10px);
        -ms-transform: translateY(10px);
        -o-transform: translateY(10px);
        transform: translateY(10px);
        -webkit-transition: all .25s ease-out;
        -moz-transition: all .25s ease-out;
        -ms-transition: all .25s ease-out;
        -o-transition: all .25s ease-out;
        transition: all .25s ease-out;
        -webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
        -moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
        -ms-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
        -o-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
    }

    /* This bridges the gap so you can mouse into the tooltip without it disappearing */
    .wrapper .tooltip:before {
        bottom: -20px;
        content: " ";
        display: block;
        height: 20px;
        left: 0;
        position: absolute;
        width: 100%;
    }

    /* CSS Triangles - see Trevor's post */
    .wrapper .tooltip:after {
        border-left: solid transparent 10px;
        border-right: solid transparent 10px;
        border-top: solid #1496bb 10px;
        bottom: -8px;
        content: " ";
        height: 0;
        left: 100%;
        margin-left: -20px;
        position: absolute;
        width: 0;
    }

 

    /* IE can just show/hide with no transition */
    .lte8 .wrapper .tooltip {
        display: none;
    }

    .lte8 .wrapper:hover .tooltip {
        display: block;
    }
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Order</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchasing</a></li>
            <li class="breadcrumb-item active">Create</li>
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
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Create Order</h4>
                        </div>
                        <div class="col-6 text-end">
                            <!-- <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Add Mode</button> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex active" data-bs-toggle="tab" href="#order" role="tab">
                                <span><i class="ti-home"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Order</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#cart" role="tab">
                                <span><i class="ti-shopping-cart"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Cart</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane p-3 active" id="order" role="tabpanel">
                            <div class="p-3 text-start">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <form class="form-horizontal" id="product-add-form" action="javascript:void(0)">
                                            @csrf
                                            <input type="hidden" name="product_number" class="item-number" value="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <label for="tb-rfname">User</label>
                                                        <div class="form-group mb-3">
                                                            <!-- <span class="input-group-text fa fa-user"></span> -->
                                                            <select class="form-control select2" name="user_id" id="user" style="width: 100%;">
                                                                <option>-- Select User --</option>
                                                                @foreach($users as $user)
                                                                <option value="{{$user->id}}" {{$user->id == $userId ? 'selected' : ''}}>{{$user->first_name}} {{$user->last_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Select Category</label>
                                                        <select name="purchase_category_id" id="ni-category-id" class="select2 form-control custom-select" style="width: 90%;">
                                                            <option value="">Select Category</option>
                                                            @foreach($purchaseCategories as $key => $val)
                                                            <option value="{{$key}}">{{$val}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="mb-3 row">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="tb-rfname">Website</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="wrapper text-end">
                                                            <i class="mdi mdi-help-circle-outline help-icon"></i>
                                                            <div class="tooltip">Copy the product detail page url from Ebay , Alibaba once you copy the url then past it here and wait for a few seconds to fetch images to select one specific image.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text fa fa-user"></span>
                                                    <input id="name" name="product_url" class="form-control" type="url" value="" placeholder="https://" />
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <div class="spinner-border text-info hide" role="status" id="website-loader">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                                <div class="col-12" id="ni-product-images">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="tb-rfname">Product Name</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="wrapper text-end">
                                                                    <i class="mdi mdi-help-circle-outline help-icon"></i>
                                                                    <div class="tooltip">Enter your product name if it does not comes from website link.</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text fa fa-user"></span>
                                                            <input id="product_name" class="form-control" type="text" name="name" placeholder="Enter the product name" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="tb-rfname">Product Platform</label>
                                                            </div> 
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text fa fa-user"></span>
                                                            <input id="product_website" class="form-control" type="text" name="website" placeholder="Enter product website" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cat-boxes hide">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3 row ">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="tb-rfname">Size</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="wrapper text-end">
                                                                        <i class="mdi mdi-help-circle-outline help-icon"></i>
                                                                        <div class="tooltip">Enter your product given size name, For example small , medium , large or in numbers if supported.</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text fa fa-user"></span>
                                                                <input id="size" class="form-control" type="text" placeholder="S/M/L Or L:32,:W 32" name="size" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3 row">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="tb-rfname">Color</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="wrapper text-end">
                                                                        <i class="mdi mdi-help-circle-outline help-icon"></i>
                                                                        <div class="tooltip">Enter color name, For example yellow , red , green , blue.</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text fa fa-user"></span>
                                                                <input id="color" class="form-control" type="text" placeholder="Yellow / Red / Grey" name="color" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <label for="tb-rfname">Quantity</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text fa fa-user"></span>
                                                            <input id="quantity" class="form-control textfield" type="number" name="quantity" placeholder="Enter the quantity of products" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <label for="tb-rfname">Product Price</label>
                                                        <p class="text-muted text-end m-0 " id="Pricerange">Price Range <span class="rangeValue"></span></p>
                                                        <div class="col-md-3">
                                                            <select class="form-control" name="currency_id">
                                                                @foreach($currencies as $currency)
                                                                @php
                                                                     $currencyId =$currency->id;
                                                                @endphp
                                                               
                                                                <option value="{{$currency->id}}" id="currencyId">{{$currency->name}} - {{$currency->symbol}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-9">
                                                            
                                                            <input id="price" class="form-control" type="number" name="price" id="price" step="0.01" placeholder="Enter product price here" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="tb-rfname">Shipping Price</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="wrapper text-end">
                                                                    <i class="mdi mdi-help-circle-outline help-icon"></i>
                                                                    <div class="tooltip">Enter your product shipping price which will be latter used in parcel to ship the product to the concerned user.</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text fa fa-user"></span>
                                                            <input id="shipping_price" class="form-control" type="number" name="shipping_price" placeholder="Enter the shipping price of product" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 row">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="tb-rfname">Tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="wrapper text-end">
                                                                    <i class="mdi mdi-help-circle-outline help-icon"></i>
                                                                    <div class="tooltip">Enter tax in number, Fixed price.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text fa fa-user"></span>
                                                            <input id="tax" class="form-control" type="number" name="tax" placeholder="Enter the tax of product" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="tb-rfname">Additonal Note</label>
                                                <div class="input-group">
                                                    <span class="input-group-text fa fa-user"></span>
                                                    <textarea type="text" rows="2" id="note" class="form-control" name="description" placeholder="Write detail about the product"></textarea>
                                                </div>
                                            </div>
                                            <div class="p-3 border-top">
                                                <div class="text-end save_btn">
                                                    <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="product-add-button">Save</button>
                                                </div>
                                                <div class="text-end d-none update_btn">
                                                    <button class="btn btn-primary rounded-pill px-4 waves-effect waves-light" id="product-update-button" data-purchase-id="">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="cart" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="checkout-form" action="javascript:void(0)">

                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table">

                                                <!-- table head -->
                                                <thead class="table-active">
                                                    <tr>
                                                        <th colspan="">
                                                            <a href="javascript:void(0)" class="sort">Name</a>
                                                        </th>
                                                        <th colspan="">
                                                            <a href="javascript:void(0)" class="sort">Description</a>
                                                        </th>
                                                        <th colspan="">
                                                            <a href="javascript:void(0)" class="sort">Qty</a>
                                                        </th>
                                                        <th colspan="">
                                                            <a href="javascript:void(0)" class="sort">Item Value</a>
                                                        </th>
                                                        <th class="text-right" colspan="">
                                                            <a href="javascript:void(0)" class="sort">Action</a>
                                                        </th>
                                                    </tr>
                                                </thead>
    
                                                <tbody id="cart-tbody">
                                                    @if(isset($cartData[0]) && !is_null($cartData))
                                                    @foreach($cartData as $details)
                                                    <input type="hidden" name="purchase_id[]" value="{{ $details->purchase_id }}">
                                                    <input type="hidden" id="User_Id" value="{{$details->user_id}}">
                                                    <tr data-id="{{ $details->purchase_id }}">
                                                        <td>{{ $details->purchase->name ?? 'N/A' }}</td>
                                                        <td>{{ $details->purchase->description ?? 'N/A' }}</td>
                                                        <td>{{ $details->purchase->quantity }}</td>
                                                        <td>{{ $details->purchase->currency->symbol }} {{ $details->purchase->price }}</td>
                                                        <td><button class="btn btn-primary btn-sm edit-cart"><i class="fa fa-edit"></i></button>&nbsp;<button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $details->purchase_id }}"><i class="fa fa-trash"></i></button></td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-primary btn-rounded ni-create-new-item"><i class="mdi mdi-plus"></i></a>
                                                        </td>
                                                         <td colspan="2" data-bs-toggle="modal" data-bs-target="#createDiscount"><strong>Create Discount</strong></td>
                                                        
                                                        <td class="text-right">
                                                            <div class="form-check">
                                                                <input class="form-check-input" name="discountCheck" type="checkbox" id="flexCheckDefault">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    Apply Discount
                                                                </label><br>
                                                                <p class="discvalue"></p>
                                                                <input type="hidden" name="discountA" class="CreatedDisc">
                                                            </div>
                                                        </td>
                                                    </tr>
    
                                                    <input type="hidden" name="user_id" value="{{ $cartData[0]->user_id ?? '' }}">
                                                    <input type="hidden" name="currency_id" value="{{ $cartData[0]->purchase->currency_id ?? '' }}">
    
                                                    <tr>
                                                        <td colspan="3"><strong>Select Address</strong></td>
                                                        <td class="text-right">
                                                            <select class="form-control reciever_address select2" name="shipping_address_id" style="width: 90%;">
                                                                @if(isset($cartData[0]->user->shipping))
                                                                @foreach($cartData[0]->user->shipping as $recieverAddress)
                                                                <option value="{{$recieverAddress->id}}">{{$recieverAddress->first_name}} {{$recieverAddress->last_name}} - {{$recieverAddress->country->name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td colspan="3"><strong>Payment Method</strong></td>
                                                        <td class="text-right">
                                                            <select class="form-control payment_method select2" name="payment_method_id" style="width: 90%;">
                                                                <option value="">--Select Payment--</option>
                                                                @foreach($paymentMethods as $method)
                                                                <option value="{{$method->id}}">{{$method->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr> -->
                                                    <input type="hidden" name="subtotal"id="subtotal" value="{{$cal->total}}">
                                                    <input type="hidden" name="shipping_price" value="{{$cal->shipping ?? '00.0'}}">
                                                    <input type="hidden" name="tax" value="{{$cal->tax ?? '00.0'}}">
                                                    <tr>
                                                        <td colspan="3"><strong>Shipping Price</strong></td>
                                                        <td class="text-right d-flex align-items-center">
                                                            <strong> {{$cartData[0]->purchase->currency->symbol ?? 'N/A'}}</strong>
                                                            <input type="text" name="shipping_price" class="form-control editAble_inputs " value="{{$cal->shipping ?? '00.0'}}" id="New_shipping_price_input" >
                                                            <input type="hidden" name="old_shipping_price" id="old_shipping_price" value=" {{$cal->shipping ?? '00.0'}}" style="border:none !important;">
    
                                                            {{-- <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->shipping ?? '00.0'}}</strong> --}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>Tax</strong></td>
                                                        <td class="text-right d-flex align-items-center">
                                                           <strong> {{$cartData[0]->purchase->currency->symbol ?? 'N/A'}}</strong>
                                                            <input type="text" name="tax" class="form-control editAble_inputs" value="{{$cal->tax ?? '00.0'}}" id="New_tax_price_input" >
                                                            <input type="hidden" name="old_tax" id="old_tax" value="{{$cal->tax ?? '00.0'}}" style="border:none !important;">
    
                                                            {{-- <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} {{$cal->tax ?? '00.0'}}</strong> --}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>Item Price</strong></td>
                                                        <td class="text-right">
                                                            <strong >{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} <span id="total">{{$cal->total ?? '00.0'}}</span></strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>Paypal Fee ( % ) </strong></td>
                                                        <td class="text-right">
                                                            <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} <span id="paypalFee">{{$cal->paypal ?? '00.0'}}</span> </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>Item Price & Administration Fee & Paypal</strong></td>
                                                        <td class="text-right">
                                                            <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} <span id="adminFee">{{$cal->adminFee ?? '00.0'}}</span></strong>
                                                        </td>
                                                    </tr>
                                                    <input type="hidden" name="eGaroshiTax" value="{{$adminFee ?? '00.0'}}">
    
                                                    <input type="hidden" name="total" value="{{$cal->tenOrderFee?? '00.0'}}">
                                                    <tr>
                                                        <td colspan="3"><strong>10% Order Fee </strong></td>
                                                        <td class="text-right">
                                                            <strong>{{$cartData[0]->purchase->currency->symbol ?? 'N/A'}} <span id="orderFee">{{$cal->tenOrderFee ?? '00.0'}}</span></strong>
                                                        </td>
                                                    </tr>
                                                    @php
                                                       $currency  = DB::table('currencies')->where('id',$currencyId)->first();
                                                    @endphp
                                                    <input type="hidden" id="currencyValue" value="{{$currency->value}}">
                                                    <input type="hidden" name="converted_amount" value="{{$cal->totalConverted ?? '00.0'}}">
                                                    <tr>
                                                        
                                                        <td colspan="3"><strong>Total Converted </strong></td>
                                                        <td class="text-right">
                                                            <strong>ƒ <span id="totalConverted">{{$cal->totalConverted ?? '00.0'}}</span> ANG</strong>
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
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="p-3 border-top">
                                            <div class="text-end">
                                                <button class="btn btn-danger rounded-pill px-4 waves-effect waves-light" id="checkout-button">Checkout</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createDiscount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Create Discount </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
        <div class="modal-body">
                <label>Discount</label>
                <input type="number" class="form-control"id='OrderDiscount' name="OrderDiscount" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="discountBtn">Create</button>
        </form>
        </div>
      </div>
    </div>
  </div>

<!-- Add modal content -->

<!-- Add modal content -->
<div class="modal fade" id="ni-add-item-add" tabindex="-1" aria-labelledby="ni-add-item-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Item</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="add-item-body">

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
<script>
    
    $(document).ready(function() {
        $('.discvalue').text(`-${0}%`);
         $('.CreatedDisc').val(0);
        $(document).on('click','#discountBtn',function(){
var discVal = $('#OrderDiscount').val();
console.log(discVal);
$.ajax({
url:'/admin/discount',
type:'POST',
headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
data:{
    discVal: discVal
},
success: function(response){
    console.log('request ok');
    if(response.discount)
    {
        console.log(response.discount);
       
        $('.discvalue').text(`-${response.discount}%`);
        $('.CreatedDisc').text(`-${response.discount}%`);
        $('.CreatedDisc').val(response.discount);
        $('#createDiscount').modal('hide');
        // handleEditInputs();
    }
},
error: function(xhr,status,error)
{
    console.log('Ajax Error in Create Discount');
}

});

});

$('.editAble_inputs').blur(handleEditInputs);
 function handleEditInputs(){
    let User_Id = $('#User_Id').val();
    let newTaxPrice = $('#New_shipping_price_input').val();
    let newShippingPrice = $('#New_tax_price_input').val();
    let discount = $('.CreatedDisc').val();
    console.log('discount', discount);
    // console.log('shipping', newShippingPrice);

    let formData = new FormData();
    formData.append('User_Id', User_Id);
    formData.append('newTaxPrice', newTaxPrice);
    formData.append('newShippingPrice', newShippingPrice);
    formData.append('discount',discount)
    var request;
    setTimeout(function(){
    request = $.ajax({
            url: "{{route('purchasing.TaxShipUpdate')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: formData,
        });
   
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                // location.reload();
                notify('success', response.success);
            }

            if (response.html) {
                $('#order').removeClass('active');
                $('#cart').addClass('active');
                $('#cart-tbody').html(response.html);
                $('#cart').focus();
                // location.reload();
            }

        }); },5000);
    // var old_Tax = $('#old_tax').val();
    // console.log(old_Tax);
    // let old_Shipping = $('#old_shipping_price').val();
    // console.log(old_Shipping);
    // var subtotal = $('#subtotal').val();
    // console.log(subtotal);

    // var currencyValue =  $('#currencyValue').val();
    // console.log('new data');

    // var newTaxPrice = $('#New_shipping_price_input').val();
    // var newShippingPrice = $('#New_tax_price_input').val();
    // console.log('new tax',newTaxPrice);
    // console.log('shipmet',newShippingPrice);

    // var discVal = $('#OrderDiscount').val();
    // var CalcOld = parseFloat(subtotal) - (parseFloat(old_Shipping) + parseFloat(old_Tax));
    // console.log('oldTax + oldshipping' + old_Tax + ' ' + old_Shipping + ' ' + parseFloat(subtotal));
    // console.log(CalcOld);
    // console.log('find new item price');
    // var itemPrice = CalcOld + (parseFloat(newShippingPrice) + parseFloat(newTaxPrice));
    // console.log(newShippingPrice + ' ' + newTaxPrice + ' calcold=' + CalcOld);
    // console.log(itemPrice);

    // var paypalFee = (itemPrice * 4.62 / 100) + 0.3;
    //     var adminfee = itemPrice + paypalFee + 3.1;
    //     var eGaroshiTax = adminfee;
    //     var tenorderFee = (adminfee * 1.1) + 2;
        
    // $('#paypalFee').text(paypalFee.toFixed(2));
    // $('#total').text(itemPrice.toFixed(2));
    // $('#adminFee').text(adminfee.toFixed(3));
    // $('#orderFee').text(tenorderFee.toFixed(2));

    // var percent = (tenorderFee * discVal) / 100;
    //     var total = tenorderFee - percent;
    //     var total_Converted = total * currencyValue;
    //     let totalConvertedOld = $('#totalConverted').text();
    //     console.log('old total converted', totalConvertedOld);
    //     $('#totalConverted').text(total_Converted.toFixed(3));
    //     $total_Converted = number_format($total_Converted, 2);

}



  // When the icon is clicked
  $('.help-icon').click(function() {
    var tooltip = $(this).closest('div').find('.tooltip');
    
    // If the tooltip is already visible, hide it
    if (tooltip.css('opacity') === '1') {
      tooltip.css('opacity', 0); 
      tooltip.css('pointer-events', 'none'); 
      tooltip.css('-webkit-transform', 'translateY(10px)'); 
      tooltip.css('-moz-transform', 'translateY(10px)'); 
      tooltip.css('-ms-transform', 'translateY(10px)'); 
      tooltip.css('-o-transform', 'translateY(10px)'); 
      tooltip.css('transform', 'translateY(10px)'); 
    } else {
      // If the tooltip is hidden, show it
      tooltip.css('opacity', 1); 
      tooltip.css('pointer-events', 'auto'); 
      tooltip.css('-webkit-transform', 'translateY(0px)'); 
      tooltip.css('-moz-transform', 'translateY(0px)'); 
      tooltip.css('-ms-transform', 'translateY(0px)'); 
      tooltip.css('-o-transform', 'translateY(0px)'); 
      tooltip.css('transform', 'translateY(0px)');
    }
  }); 
});

    function showTooltip(element) {
        const tooltip = element.nextElementSibling;
        tooltip.style.visibility = 'visible';
        tooltip.style.opacity = '1';
    }

    function hideTooltip() {
        const tooltips = document.querySelectorAll('.tooltiptext');
        tooltips.forEach(tooltip => {
            tooltip.style.visibility = 'hidden';
            tooltip.style.opacity = '0';
        });
    }
    $('.select2').select2();
    $(document).on('click', "#product-add-button", function() {

        // Collecting Current Form Data 
        forms = $("#product-add-form")[0];
        var form = new FormData(forms);

        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('purchasing.product.cart')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: form,
        });
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                notify('success', response.success);
            }

            if (response.html) {
                $('#order').removeClass('active');
                $('#cart').addClass('active');
                $('#cart-tbody').html(response.html);
                $('#cart').focus();
                location.reload();
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            if (jqXHR.status == '422') {
                notify('error', "The Given Data Is Invalid");
                $('.invalid-feedback').remove()
                $(":input").removeClass('is-invalid')
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function(index, value) {
                    if ($("input[name=" + index + "]").length) {
                        $("input[name=" + index + "]").addClass('is-invalid');
                        $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }


                    if ($("select[name=" + index + "]").length) {
                        $("select[name=" + index + "]").addClass('is-invalid');
                        $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                    if ($("textarea[name=" + index + "]").length) {
                        $("textarea[name=" + index + "]").addClass('is-invalid');
                        $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                });
            }
        });

    });

    $(document).on('click', ".ni-create-new-item", function(e) {
        let url = "{{route('purchasing.create.item')}}";
        getHtmlAjax(url, "#ni-add-item-add", "#add-item-body")
    });


    $(document).on('click', ".edit-cart", function(e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: "{{ route('purchasing.cart.edit') }}",
            method: "GET",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id")
            },
            success: function(response) {
                $('#product-add-form')[0].reset();
                if (response) {
                    $('#user').val(response.user_id).trigger('change');
                    $('#name').val(response.product_url);
                    $('#product_name').val(response.name);
                    $('#product_website').val(response.website);
                    $('#size').val(response.size);
                    $('#color').val(response.color);
                    $('#quantity').val(response.quantity);
                    $('#price').val(response.price);
                    $('#note').val(response.description);
                    $('#shipping_price').val(response.shipping_price);
                    $('#tax').val(response.tax);

                    $('.save_btn').addClass('d-none');
                    $('.update_btn').removeClass('d-none');
                    $('#product-update-button').attr('data-purchase-id', response.id);
                    $('#order').addClass('active');
                    $('#cart').removeClass('active');
                }
            }
        });
    });


    $(document).on('click', "#product-update-button", function() {

        // Collecting Current Form Data 
        let formId = "#product-add-form";
        forms = $(formId)[0];
        var form = new FormData(forms);
        var purchase_id = $(this).data('purchase-id');
        form.append('purchase_id', purchase_id);

        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('purchasing.update.cart')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: form,
        });
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                notify('success', response.success);
            }

            if (response.html) {
                $('#order').removeClass('active');
                $('#cart').addClass('active');
                $('#cart-tbody').html(response.html)
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            if (jqXHR.status == '422') {
                notify('error', "The Given Data Is Invalid");
                $('.invalid-feedback').remove()
                $(":input").removeClass('is-invalid')
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function(index, value) {
                    if ($("input[name=" + index + "]").length) {
                        $("input[name=" + index + "]").addClass('is-invalid');
                        $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }


                    if ($("select[name=" + index + "]").length) {
                        $("select[name=" + index + "]").addClass('is-invalid');
                        $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                    if ($("textarea[name=" + index + "]").length) {
                        $("textarea[name=" + index + "]").addClass('is-invalid');
                        $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                });
            }
        });

    });

    $(document).on('blur', "#name", function() {

        let site_url = $(this).val();
       if (site_url) {
            $('#ni-product-images').html('');
            $("#website-loader").removeClass('hide');
            var request = $.ajax({
                url: "{{route('purchasing.url.content')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: {
                    site_url: site_url
                },
            });
            // Ajax on Done Section here
            request.done(function(response) {

                if (response.success) {
                    notify('success', response.success);
                    $("#website-loader").addClass('hide');
                }

                if (response.html) {
                    $('#ni-product-images').html(response.html);
                }

            });
            request.fail(function(jqXHR, textStatus) {
                // Toaster on Error like validation
                if (jqXHR.status == '422') {
                    notify('error', "The Given Data Is Invalid");
                    $('.invalid-feedback').remove()
                    $(":input").removeClass('is-invalid')
                    var errors = jqXHR.responseJSON.errors;
                    $.each(errors, function(index, value) {
                        if ($("input[name=" + index + "]").length) {
                            $("input[name=" + index + "]").addClass('is-invalid');
                            $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                        }


                        if ($("select[name=" + index + "]").length) {
                            $("select[name=" + index + "]").addClass('is-invalid');
                            $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                        }

                        if ($("textarea[name=" + index + "]").length) {
                            $("textarea[name=" + index + "]").addClass('is-invalid');
                            $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                        }

                    });
                }
            });
        }


    });


    $(document).on('click', ".remove-from-cart", function() {
        var ele = $(this);
        var url = "{{route('purchasing.remove.from.cart')}}";
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'mr-2 btn btn-danger'
            },
            buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to remove item from cart",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Remove it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var request = $.ajax({
                    url: url,
                    method: "DELETE",
                    data: {
                        "_token": "{{csrf_token()}}",
                        id: ele.data('id'),
                    },
                    dataType: "json",
                });
                request.done(function(response) {
                    if (response.success) {
                        notify('success', response.success);
                    }

                    if (response.html) {
                        $('#order').removeClass('active');
                        $('#cart').addClass('active');
                        $('#cart-tbody').html(response.html)
                    }
                    $('#product-add-form')[0].reset();
                });
                request.fail(function(jqXHR, textStatus) {
                    if (jqXHR.status == '422') {
                        notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary data is safe :)',
                    'error'
                )
            }
        })

    })


    $(document).on('click', "#checkout-button", function() {

        // Collecting Current Form Data 
        let formId = "#checkout-form";
        forms = $(formId)[0];
        var form = new FormData(forms);

        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('purchasing.product.checkout')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: form,
        });
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                notify('success', response.success);
                let url = response.redirect;
                setTimeout(function() {
                    window.location.href = url;
                }, 2000);

            }
            if (response.error) {
                notify('error', response.error);
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            if (jqXHR.status == '422') {
                notify('error', "The Given Data Is Invalid");
                $('.invalid-feedback').remove()
                $(":input").removeClass('is-invalid')
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function(index, value) {
                    if ($("input[name=" + index + "]").length) {
                        $("input[name=" + index + "]").addClass('is-invalid');
                        $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }


                    if ($("select[name=" + index + "]").length) {
                        $("select[name=" + index + "]").addClass('is-invalid');
                        $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                    if ($("textarea[name=" + index + "]").length) {
                        $("textarea[name=" + index + "]").addClass('is-invalid');
                        $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                });
            }
        });

    });
    $(document).on('change', "#ni-category-id", function() {

        var value = $(this).val();

        if (value != '' && value != null && value != 'undefined') {

            $('.cat-boxes').removeClass("hide");

        } else {

            $('.cat-boxes').addClass("hide");

        }

    })
</script>
@endpush