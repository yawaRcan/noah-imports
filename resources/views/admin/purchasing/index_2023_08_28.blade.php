@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Orders</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
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
            @if($orderAmountDue > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Alert!</strong> Total Purchase order amount due is ƒ {{$orderAmountDue}} ANG
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Order Create</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{route('purchasing.create')}}" class="btn btn-light-info text-info font-weight-medium waves-effect">Create Order</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-hover table no-wrape data-table">
                        <thead>
                            <tr>
                                <th class="border">No#</th>
                                <th class="border">#Order No</th>
                                <th class="border">Reciever</th>
                                <th class="border">Amount</th>
                                <th class="border">Order Status</th>
                                <th class="border">Status</th>
                                <th class="border">Payments</th>
                                <th class="border">created_at</th>
                                <th class="border">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-shipment-mode-edit" tabindex="-1" aria-labelledby="ni-shipment-mode-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="shipmode-edit">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Add modal content -->
<div class="modal fade" id="ni-payment-change-modal" tabindex="-1" aria-labelledby="ni-payment-change-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Update Payment Status</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="payment-change-body">

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
    var table
    table();

    function table(params = null) { 
        
        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('purchasing.order.data')}}" ,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'reciever',
                    name: 'reciever'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'delivery_status',
                    name: 'delivery_status'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'payment_status',
                    name: 'payment_status'
                },
                
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }


    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {
        let id = $(this).data("order-id");
        let url = "{{route('purchasing.getPaymentHtml',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
    })
</script>
@endpush