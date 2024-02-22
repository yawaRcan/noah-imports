@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Reports</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Consolidates</a></li>
            <li class="breadcrumb-item active">Pending Consolidates</li>
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
                            <h4 class="card-title mb-0">Pending Consolidates</h4>
                        </div>
                        <div class="col-6 text-end">
                            <form method="GET" id="pending_consolidates_form" class="form-inline" action="{{route('reports.consolidates.pending')}}">
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
                                <th class="border">Date</th>
                                <th class="border">Tracking</th>
                                <th class="border">Sender</th>
                                <th class="border">Reciever</th>
                                <th class="border">Destination</th>
                                <th class="border">Payment method</th>
                                <th class="border">Payment status</th>
                                <th class="border">Status</th>
                                <th class="border">Weight(LB)</th>
                                <th class="border">Freight type</th>
                                <th class="border">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalFee = 0 @endphp
                            @foreach($consolidates as $key => $consolidate)
                                @php 
                                    $total = $consolidate->amount_total;
                                    $totalFee += $total;
                                @endphp
                                <tr>
                                    <td>{{$consolidate->created_at->format('F j, Y h:i A') ?? 'N/A'}}</td>
                                    <td>{{$consolidate->external_tracking ?? 'N/A'}}</td>
                                    <td>{{ucwords($consolidate->sender->address ?? 'N/A')}}</td>
                                    <td>{{ucwords($consolidate->reciever->address ?? 'N/A')}}</td>
                                    <td>{{$consolidate->toCountry->name ?? 'N/A'}}</td>
                                    <td>{{$consolidate->payment->name ?? 'N/A'}}</td>
                                    <td>{{$consolidate->paymentStatus->name ?? 'N/A'}}</td>
                                    <td>Pending</td>
                                    <td>{{$consolidate->weight ?? 'N/A'}}</td>
                                    <td>{{$consolidate->freight_type ?? 'N/A'}}</td>
                                    <td>{{$total}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="10"></td>
                                <td class="text-right"><b>ƒ {{ number_format($totalFee, 2) }} ANG</b></td>
                            </tr>
                        </tbody>
                    </table>
                    {{ $consolidates->links() }}
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
        $('#pending_consolidates_form').submit();
    }

</script>
@endpush