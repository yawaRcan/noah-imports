@extends('user.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Purchasing</h3>
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
                    <h4 class="mb-0 text-dark">Order No #{{$order->code ?? 'N/A'}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Status : <span class="mb-1 badge text-white" style="background-color: {{$order->deliveryStatus->color  ?? 'N/A'}} ">{{$order->deliveryStatus->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Payment Status : <span class="mb-1 badge text-white" style="background-color: {{$order->paymentStatus->color  ?? 'N/A'}} ">{{$order->paymentStatus->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Payment Method</p>
                            <p> <span class="card-text">{{$order->billing[0]->payment->name ?? 'N/A'}}</span></p>
                        </div>
                        
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Date</p>
                            <p> <span class="card-text">{{$order->created_at ? date('d-m-Y', strtotime($order->created_at)) : 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Payments : <span class="mb-1 badge bg-primary">Online Shop</span></p>
                        </div>
                        <!-- <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Waybill: <span class="fw-bold"></span></p>
                        </div> -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Invoice</p>
                            <p> <span class="card-text">{{$order->invoice ?? 'N/A'}}</span></p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Date Ordered</p>
                            <p> <span class="card-text">{{$order->created_at ? date('d-m-Y', strtotime($order->created_at)) : 'N/A'}}</span></p>
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
                                    <th>IMAGE</th>
                                    <th>WEBSITE</th>
                                    <th>NAME</th>
                                    <th>SIZE</th>
                                    <th>COLOR</th>
                                    <th>ADDITIONAL NOTE</th>
                                    <th>QUANTITY</th>
                                    <th>PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchases as $key => $purchase)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td><img src="{{$purchase->image_url}}" alt="" width="50px"></td>
                                    <td>{{$purchase->website ?? 'N/A'}}</td>
                                    <td><a href="{{$purchase->product_url ?? 'javascript:void(0)'}}" target="_blank">{{$purchase->name ?? 'N/A'}}</a></td>
                                    <td>{{$purchase->size ?? 'N/A'}}</td>
                                    <td>{{$purchase->color ?? 'N/A'}}</td>
                                    <td>{{$purchase->description ?? 'N/A'}}</td>
                                    <td>{{$purchase->quantity ?? 'N/A'}}</td>
                                    <td>{{$purchase->currency->symbol ?? 'N/A'}} {{$purchase->price ?? 'N/A'}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="8"><strong>Items Price</strong></td>
                                    <td class="text-right">
                                        <strong>{{$order->currency->symbol ?? 'N/A'}} {{$cal->total ?? '00.0'}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8"><strong>Items Price & Administration Fee & Paypal</strong></td>
                                    <td class="text-right">
                                        <strong>{{$order->currency->symbol ?? 'N/A'}} {{$cal->adminFee ?? '00.0'}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8"><strong>Total</strong></td>
                                    <td class="text-right">
                                        <strong>{{$order->currency->symbol ?? 'N/A'}} {{$cal->tenOrderFee ?? '00.0'}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8"><strong>Total Converted</strong></td>
                                    <td class="text-right">
                                        <strong>ƒ {{$cal->totalConverted ?? '00.0'}}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-6">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Sender's Info</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <p class="card-text">First Name : <span class="fw-bold">{{$senderAddress->morphable->first_name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Last Name : <span class="fw-bold">{{$senderAddress->morphable->last_name ?? 'N/A'}}</span></p>
                        </div>
                    </div>
                    <br>
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <p class="card-text">Address : <span class="fw-bold">{{$senderAddress->address ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Phone : <span class="fw-bold">{{$senderAddress->phone ?? 'N/A'}}</span></p>
                        </div>
                    </div><br>
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <p class="card-text">Country : <span class="fw-bold">{{$senderAddress->country->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Courier : <span class="fw-bold">{{$order->courierDetail->name ?? 'N/A'}}</span></p>
                        </div>
                    </div><br>
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <p class="card-text">AWB : <span class="fw-bold">{{$order->awb ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Tracking : <span class="fw-bold">{{$order->tracking ?? 'N/A'}}</span></p>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Destination</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <p class="card-text">First Name : <span class="fw-bold">{{$order->shipperAddress->morphable->first_name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Last Name : <span class="fw-bold">{{$order->shipperAddress->morphable->last_name ?? 'N/A'}}</span></p>
                        </div>
                    </div>
                    <br>
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <p class="card-text">Address : <span class="fw-bold">{{$order->shipperAddress->address ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Phone : <span class="fw-bold">{{$order->shipperAddress->phone ?? 'N/A'}}</span></p>
                        </div>
                    </div><br>
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <p class="card-text">Country : <span class="fw-bold">{{$order->shipperAddress->country->name ?? 'N/A'}}</span></p>
                        </div>
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