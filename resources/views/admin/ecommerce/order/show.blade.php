@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Ecommerce</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
            <li class="breadcrumb-item active">View Order</li>
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
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Order No #{{$order->order_number ?? 'N/A'}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Order Status</p>
                            <p> <span class="card-text">{{$order->status ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Payment Status </p>
                            <p> <span class="mb-1 badge text-white" style="background-color: {{$order->paymentStatus->color  ?? 'N/A'}} ">{{$order->paymentStatus->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Payment Method</p>
                            <p> <span class="card-text">{{$order->payment->name ?? 'N/A'}}</span></p>
                        </div>
                        
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Date</p>
                            <p> <span class="card-text">{{$order->created_at ? date('d-m-Y', strtotime($order->created_at)) : 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Payments </p>
                            <p><span class="mb-1 badge bg-primary">Online Shop</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Order Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>SIZE</th>
                                    <th>QUANTITY</th>
                                    <th>PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $key => $cart)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$cart->product->title ?? 'N/A'}}</td>
                                    <td>{{$cart->product->size ?? 'N/A'}}</td>
                                    <td>{{$cart->quantity ?? 'N/A'}}</td>
                                    <td>{{$cart->currency->symbol ?? 'N/A'}} {{$cart->price ?? 'N/A'}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4"><strong>Items Price</strong></td>
                                    <td class="text-right">
                                        <strong>{{$order->currency->symbol ?? 'N/A'}} {{$cal->total ?? '00.0'}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><strong>Items Price & Administration Fee & Paypal</strong></td>
                                    <td class="text-right">
                                        <strong>{{$order->currency->symbol ?? 'N/A'}} {{$cal->adminFee ?? '00.0'}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><strong>Total</strong></td>
                                    <td class="text-right">
                                        <strong>{{$order->currency->symbol ?? 'N/A'}} {{$cal->tenOrderFee ?? '00.0'}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><strong>Total Converted</strong></td>
                                    <td class="text-right">
                                        <strong>ƒ {{$cal->totalConverted ?? '00.0'}} ANG</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('footer-script')
<script>
</script>
@endpush