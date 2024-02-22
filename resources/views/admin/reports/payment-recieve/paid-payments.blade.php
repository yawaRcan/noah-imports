@extends('admin.layout.master')

@section('content')
<style type="text/css">
    @media print {
      body * {
        visibility: hidden;
      }
      .data-table, .data-table * {
        visibility: visible;
      }
      .data-table {
        width: auto !important;
        max-width: 100% !important;
        table-layout: auto !important;
        font-size: 10px !important;
      }
    }
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Reports</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Payments</a></li>
            <li class="breadcrumb-item active">Payments Recieved</li>
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
                            <h4 class="card-title mb-0">Payments Recieved</h4>
                        </div>
                        <div class="col-6 text-end">

                            <form method="GET" id="payment_recieve_form" class="form-inline" action="{{route('reports.payment.recieve')}}">
                                <input type="hidden" name="export" id="export">
                                <!-- <button type="button" onclick="printTableData()" class="btn btn-info no-print">Print</button> -->
                                <button type="button" onclick="download()" class="btn btn-primary">Export</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive" style="overflow-x: auto;">
                    <table class="table-bordered table-hover table no-wrape data-table">
                        <thead>
                            <tr>
                                <th class="border">Date</th>
                                <th class="border">Customer Name</th>
                                <th class="border">Payment method</th>
                                <th class="border">Tracking</th>
                                <th class="border">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalFee = 0 @endphp
                            @foreach($usersAmount as $key => $userAmount)
                                @php 
                                    $total = $userAmount->amount_total;
                                    $totalFee += $total;
                                @endphp
                                <tr>
                                    <td>{{$userAmount->es_delivery_date->format('F j, Y h:i A') ?? 'N/A'}}</td>
                                    <td>{{ucwords($userAmount->user->first_name) ?? 'N/A'}} {{ucwords($userAmount->user->last_name) ?? 'N/A'}}</td>
                                    <td>{{$userAmount->payment->name ?? 'N/A'}}</td>
                                    <td>{{$userAmount->external_tracking ?? 'N/A'}}</td>
                                    <td>{{$total}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-right"><b>ƒ {{ number_format($totalFee, 2) }} ANG</b></td>
                            </tr>
                        </tbody>
                    </table>
                    {{ $usersAmount->links() }}
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
        $('#payment_recieve_form').submit();
    }

    function printTableData() {
      window.print();
    }

</script>
@endpush