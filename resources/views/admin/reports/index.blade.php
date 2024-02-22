@extends('admin.layout.master')

@section('content')
@push('head-script')
<link href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
@endpush
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Generate Report</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Reports</a></li>
            <li class="breadcrumb-item active">List</li>
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
        <div class="col-md-6 col-lg-4">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Online Shop</h4>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <ul class="list-group">
                           <li class="list-group-item"><a href="{{route('reports.orders.list')}}" target="_blank">All orders</a></li>
                           <li class="list-group-item"><a href="{{route('reports.orders.pending')}}" target="_blank">Pending orders</a></li>
                           <li class="list-group-item"><a href="{{route('reports.orders.paid')}}" target="_blank">Paid orders</a></li>
                           <li class="list-group-item"><a href="{{route('reports.orders.unpaid')}}" target="_blank">Unpaid orders</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Shipment</h4>
                        </div>
                        <div class="col-6 text-end">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <ul class="list-group">
                           <li class="list-group-item"><a href="{{route('reports.parcels.list')}}" target="_blank">All Shipments</a></li>
                           <li class="list-group-item"><a href="{{route('reports.parcels.pending')}}" target="_blank">All pending shipments</a></li>
                           <li class="list-group-item"><a href="{{route('reports.parcels.paid')}}" target="_blank">All paid shipments</a></li>
                           <li class="list-group-item"><a href="{{route('reports.parcels.unpaid')}}" target="_blank">All unpaid shipments</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Consolidate</h4>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <ul class="list-group">
                           <li class="list-group-item"><a href="{{route('reports.consolidates.list')}}" target="_blank">All Consolidate</a></li>
                           <li class="list-group-item"><a href="{{route('reports.consolidates.pending')}}" target="_blank">All pending consolidate</a></li>
                           <li class="list-group-item"><a href="{{route('reports.consolidates.paid')}}" target="_blank">All paid consolidate</a></li>
                           <li class="list-group-item"><a href="{{route('reports.consolidates.unpaid')}}" target="_blank">All unpaid consolidate</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Backup</h4>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <ul class="list-group">
                           <li class="list-group-item"><a href="{{route('reports.database.backup')}}">Backup Database</a></li>
                           <li class="list-group-item"><a href="{{route('reports.data.clean')}}">Empty unused data => Safe for data storage space</a></li>
                           <li class="list-group-item"><a href="{{route('reports.site.backup')}}">Website Backup</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Account</h4>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <ul class="list-group">
                           <li class="list-group-item"><a href="{{route('reports.payment.recieve')}}">Payments received</a></li>
                        </ul>
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