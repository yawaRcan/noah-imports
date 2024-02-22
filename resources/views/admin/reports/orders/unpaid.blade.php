@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Reports</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Orders</a></li>
            <li class="breadcrumb-item active">UnPaid Orders</li>
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
                            <h4 class="card-title mb-0">UnPaid Orders</h4>
                        </div>
                        <div class="col-6 text-end">
                            <form method="GET" id="unpaid_orders_form" class="form-inline" action="{{route('reports.orders.unpaid')}}">
                            <input type="hidden" name="export" id="export">
                            <button type="button" onclick="download()" class="btn btn-primary">Export Report</button>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-hover table no-wrape data-table">
                        <thead>
                            <tr>
                                <th class="border">No#</th>
                                <th class="border">Date</th>
                                <th class="border">Order No</th>
                                <th class="border">Tracking No</th>
                                <th class="border">Invoice No</th>
                                <th class="border">Courier</th>
                                <th class="border">Receiver</th>
                                <th class="border">Destination</th>
                                <th class="border">Payment method</th>
                                <th class="border">Payment status</th>
                                <th class="border">Status</th>
                                <th class="border">AWB</th>
                                <th class="border">Date ordered</th>
                                <th class="border">Qty</th>
                                <th class="border">Price</th>
                                <th class="border">10% order fee</th>
                                <th class="border">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalFee = 0 @endphp
                            @foreach($orders as $key => $order)
                                <tr>
                                    @php 
                                    $total = $order->amount_converted;
                                    $totalFee += $total;
                                    @endphp
                                    <td>{{++$key}}</td>
                                    <td>{{$order->created_at->format('F j, Y h:i A') ?? 'N/A'}}</td>
                                    <td>{{$order->code ?? 'N/A'}}</td>
                                    <td>{{$order->tracking ?? 'N/A'}}</td>
                                    <td>{{$order->invoice ?? 'N/A'}}</td>
                                    <td>{{$order->courierDetail->name ?? 'N/A'}}</td>
                                    <td>{{ucwords($order->shipperAddress->name) ?? 'N/A'}}</td>
                                    <td>{{$order->shipperAddress->country->name ?? 'N/A'}}</td>
                                    <td>{{$order->billing[0]->payment->name ?? 'N/A'}}</td>
                                    <td>UnPaid</td>
                                    <td>{{$order->status == 0 ? 'Pending' : 'Active'}}</td>
                                    <td>{{$order->awb ?? 'N/A'}}</td>
                                    <td>{{$order->created_at->format('F j, Y h:i A') ?? 'N/A'}}</td>
                                    <td>{{$order->total_qty ?? 'N/A'}}</td>
                                    <td>{{$order->currency->name ?? 'N/A'}} {{$order->sub_total ?? 'N/A'}}</td>
                                    <td>{{$order->currency->name ?? 'N/A'}} {{$total ?? 'N/A'}}</td>
                                    <td>{{$order->amount_converted ? 'ƒ '.$order->amount_converted :'N/A'}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="16"></td>
                                <td class="text-right"><b>ƒ {{ number_format($totalFee, 2) }} ANG</b></td>
                            </tr>
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')


<script>

    function download() {
        $('#export').val(true);
        $('#unpaid_orders_form').submit();
    }

</script>
@endpush