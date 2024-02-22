@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">User</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">User</li>
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
    <div class="row mb-2">
        <div class="col-12 col-sm-12 col-md-5">
            <div class="card text-center card-hover">
                <div class="card-body">
                    <img src="{{asset('storage/assets/user-profile/')}}/{{isset($user->image) ? $user->image : 'upload.jpeg'}}" class="rounded-3 img-fluid" width="90">
                    <div class="mt-n2">
                        <span class="badge bg-danger">Customer</span>
                        <h3 class="card-title mt-3">{{$user->first_name ?? ''}} {{$user->last_name ?? ''}}</h3>
                        <h6 class="card-subtitle">{{$user->email}}</h6>
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-6 col-xl-3">
                            <div class="py-2 px-3 bg-light rounded-pill d-flex align-items-center">
                                <span class="text-warning"><i class="mdi mdi-cash display-7"></i></span>
                                <div class="ms-2 text-start">
                                    <h6 class="fw-normal text-muted mb-0">Balance</h6>
                                    @if($user->balance() < 0)
                                    <h4 class="mb-0 text-danger">ƒ{{$user->balance() ?? ''}}</h4>
                                    @else
                                    <h4 class="mb-0">ƒ{{$user->balance() ?? ''}}</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-xl-3">
                            <div class="py-2 px-3 bg-light rounded-pill d-flex align-items-center">
                                <span class="text-primary"><i class="mdi mdi-map display-7"></i></span>
                                <div class="ms-2 text-start">
                                    <h6 class="fw-normal text-muted mb-0">Country</h6>
                                    <h4 class="mb-0">{{$user->initial_country ?? 'US'}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-7">
            <div class="card text-center card-hover">
                <div class="card-body" style="height:265px">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="btn btn-primary btn-rounded w-100"> Username :<br> {{$user->username ?? ''}}</div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="btn btn-success btn-rounded w-100"> Gender : <br> {{$user->gender == 1 ? 'Male':'Female' ?? 'Other'}}</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="btn btn-success btn-rounded w-100"> Mobile number : <br> {{$user->phone ?? '+923345678756'}}</div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="btn btn-primary btn-rounded w-100"> Country :<br> {{$user->country->name ?? 'United State America'}}</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="btn btn-primary btn-rounded w-100"> Registered At :<br> {{ \Carbon\Carbon::parse($user->created_at)->setTimezone((isset($user->timezone->name) ? $user->timezone->name : 'US/Samoa'))->format('Y-m-d') ?? ''}}</div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="btn btn-success btn-rounded w-100"> Last Login : <br> {{\Carbon\Carbon::parse($user->last_login)->setTimezone((isset($user->timezone->name) ? $user->timezone->name : 'US/Samoa'))->diffForHumans() ?? ''}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($geoLocation)
        <div class="row">
            <div class="col-12">
                <div class="card card-hover">
                    <div class="card-header">
                        <h4 class="mb-0 text-dark">Geo Location</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mt-4">
                            <div class="col-12 col-sm-6 col-md-4">
                                <p class="fw-bold">Country Name</p>
                                <p> <span class="card-text">{{$geoLocation->countryName}}</span></p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <p class="fw-bold">Country Code</p>
                                <p> <span class="card-text">{{$geoLocation->countryCode}}</span></p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <p class="fw-bold">Zip code</p>
                                <p> <span class="card-text">{{$geoLocation->zipCode}}</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-4">
                            <div class="col-12 col-sm-6 col-md-4">
                                <p class="fw-bold">Region Name</p>
                                <p> <span class="card-text">{{$geoLocation->regionName}}</span></p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <p class="fw-bold">Region Code</p>
                                <p> <span class="card-text">{{$geoLocation->regionCode}}</span></p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <p class="fw-bold">City Name</p>
                                <p> <span class="card-text">{{$geoLocation->cityName}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body shadow">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                        <li class="nav-item bg-primary m-2 shadow card-hover">
                            <a class="nav-link active" data-bs-toggle="tab" href="#navpill-111" role="tab">
                                <span class="text-white">Purchases ({{$count['purchases'] ?? ''}})</span>
                            </a>
                        </li>
                        <li class="nav-item bg-primary m-2 shadow card-hover">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpill-222" role="tab">
                                <span class="text-white">Active Parcels ({{$count['parcels'] ?? ''}})</span>
                            </a>
                        </li>
                        <li class="nav-item bg-primary m-2 shadow card-hover">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpill-333" role="tab">
                                <span class="text-white">Consolidates ({{$count['consolidate'] ?? ''}})</span>
                            </a>
                        </li>
                        <li class="nav-item bg-primary m-2 shadow card-hover">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpill-444" role="tab">
                                <span class="text-white">Wallet ({{$count['wallets'] ?? ''}})</span>
                            </a>
                        </li>
                        <li class="nav-item bg-primary m-2 shadow card-hover">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpill-555" role="tab">
                                <span class="text-white">Archived Parcels ({{$count['archived_parcels'] ?? ''}})</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content border mt-2">
                        <div class="tab-pane active p-3" id="navpill-111" role="tabpanel">
                            <table class="table table-striped table-hover table-bordered display dataTable" id="purchases-data-table">
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
                        <div class="tab-pane p-3" id="navpill-222" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Bulk Action</label>
                                    <select id="ni-action" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="--select--">-- Select --</option>
                                        <option value="consolidate">Consolidate</option>
                                        <option value="draft-shipment">Draft Shipment</option>
                                        <option value="delete-shipment">Delete Shipment</option>
                                    </select>
                                </div>
                                <div class="col-6 text-end">
                                    <!-- <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Add Mode</button> -->
                                    <a href="javascript:void(0)" class="btn btn-light-warning text-success font-weight-medium waves-effect pay_btn hide">
                                        Pay Now
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered display dataTable" id="parcels-data-table">
                                    <thead>
                                        <tr>
                                            <th class="border check-order"><input type="checkbox" id="check-all"></th>
                                            <th class="border">No#</th>
                                            <th class="border">Invoice</th>
                                            <th class="border">Reciever</th>
                                            <th class="border">Destination</th>
                                            <th class="border">Description</th>
                                            <th class="border">Amounts</th>
                                            <th class="border">Payments</th>
                                            <th class="border">Invoice Status</th>
                                            <th class="border">Status</th>
                                            <th class="border">created_at</th>
                                            <th class="border">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="tab-pane p-3" id="navpill-333" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered display dataTable" id="consolidate-data-table">
                                    <thead>
                                        <tr>
                                            <th class="border">No#</th>
                                            <th class="border">Invoice</th>
                                            <th class="border">waybill</th>
                                            <th class="border">Sender</th>
                                            <th class="border">Reciever</th>
                                            <th class="border">Amounts</th>
                                            <th class="border">Payments</th>
                                            <th class="border">Invoice Status</th>
                                            <th class="border">Status</th>
                                            <th class="border">created_at</th>
                                            <th class="border">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="navpill-444" role="tabpanel">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="card bg-orange text-white">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                                <a href="JavaScript: void(0);"><i class="display-6 cc BTC-alt text-white" title="BTC"></i></a>
                                                <div class="ms-3 mt-2">
                                                    <h4 class="font-weight-medium mb-0 text-white">Current Balance</h4>
                                                    
                                                    @if($user->balance() < 0)
                                                        <h5 class="" style="color: #FF0000;">ƒ {{$user->balance()}} ANG</h5>
                                                    @else
                                                        <h5 class="text-white">ƒ {{$user->balance()}} ANG</h5>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                                <a href="JavaScript: void(0);"><i class="display-6 cc BTC-alt text-white" title="BTC"></i></a>
                                                <div class="ms-3 mt-2">
                                                    <h4 class="font-weight-medium mb-0 text-white">Total Credited</h4>
                                                    <h5 class="text-white">ƒ {{$user->credit()}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                                <a href="JavaScript: void(0);"><i class="display-6 cc BTC-alt text-white" title="BTC"></i></a>
                                                <div class="ms-3 mt-2">
                                                    <h4 class="font-weight-medium mb-0 text-white">Total Debited</h4>
                                                    <h5 class="text-white">ƒ {{$user->debit()}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                     
                                        <table class="table table-striped table-hover table-bordered display dataTable" id="wallet-data-table">
                                            <thead>
                                                <tr>
                                                    <th class="border">No#</th>
                                                    <th class="border">User</th>
                                                    <th class="border">Transaction Type</th>
                                                    <th class="border">Payment Method</th>
                                                    <th class="border">Total Amount</th>
                                                    <th class="border">Total Converted</th>
                                                    <th class="border">Payment Receipt</th>
                                                    <th class="border">Status</th>
                                                    <th class="border">Date/Time</th>
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
                        <div class="tab-pane p-3" id="navpill-555" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered display dataTable" id="parcels-archive-data-table">
                                    <thead>
                                        <tr>
                                            <th class="border check-order"><input type="checkbox" id="check-all"></th>
                                            <th class="border">No#</th>
                                            <th class="border">Invoice</th>
                                            <th class="border">Reciever</th>
                                            <th class="border">Destination</th>
                                            <th class="border">Description</th>
                                            <th class="border">Amounts</th>
                                            <th class="border">Payments</th>
                                            <th class="border">Invoice Status</th>
                                            <th class="border">Status</th>
                                            <th class="border">created_at</th>
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
        </div>
    </div>

</div>


<!-- Add modal content Purchases  -->
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

<!-- Add modal content -->
<div class="modal fade" id="ni-pay-parcel-modal" tabindex="-1" aria-labelledby="ni-pay-parcel-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Pay Parcels Amount</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pay-parcel-body">

            </div>
            <div class="modal-footer">
                <button type="button" id="proceed-to-pay" class="btn btn-primary">Proceed</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Edit modal content -->
<div class="modal fade" id="ni-consolidate-mode-edit" tabindex="-1" aria-labelledby="ni-consolidate-mode-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Consolidate</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="consolidate-edit">

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
    var purchasesTable
    purchasesTable();
    var parcelsTable
    parcelsTable();
    var parcelsArchiveTable
    parcelsArchiveTable();
    var consolidaTable
    consolidaTable();
    var walletTable
    walletTable();

    function purchasesTable(params = null) {

        purchasesTable = $('#purchases-data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('purchasing.order.data')}}?user_id=" + "{{$user->id}}",
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
        if (id) {
            let url = "{{route('purchasing.getPaymentHtml',['id' => ':id'])}}";
            url = url.replace(':id', id);
            // Function to get html of Payment Data
            getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
        }

    })

    // Parcels Script 
    function parcelsTable(status = '', draft = '') {

        parcelsTable = $('#parcels-data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('parcel.data')}}?drafted=" + draft + "&status=" + status + "&user_id=" + "{{$user->id}}",
            "fnDrawCallback": function(param) {
                $('.check-order').removeClass('sorting sorting_asc sorting_desc');
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'invoice',
                    name: 'invoice'
                },
                {
                    data: 'reciever',
                    name: 'reciever'
                },
                {
                    data: 'destination',
                    name: 'destination'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'payment',
                    name: 'payment'
                },
                {
                    data: 'invoice_status',
                    name: 'invoice_status'
                },
                {
                    data: 'status',
                    name: 'status'
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

    function parcelsArchiveTable(params = null) {

        parcelsArchiveTable = $('#parcels-archive-data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('parcel.archivedParcels')}}?user_id=" + "{{$user->id}}",
            "fnDrawCallback": function(param) {
                $('.check-order').removeClass('sorting sorting_asc sorting_desc');
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'invoice',
                    name: 'invoice'
                },
                {
                    data: 'reciever',
                    name: 'reciever'
                },
                {
                    data: 'destination',
                    name: 'destination'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'payment',
                    name: 'payment'
                },
                {
                    data: 'invoice_status',
                    name: 'invoice_status'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ]
        });
    }




    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {

        let id = $(this).data("parcel-id");
        if (id) {
            let url = "{{route('parcel.getPaymentHtml',['id' => ':id'])}}";
            url = url.replace(':id', id);
            // Function to get html of Payment Data
            getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
        }

    })

    // checking checkboxes
    $('#check-all').change(function() {

        $('.parcel-checkbox').prop('checked', this.checked);
        var flag = false;
        var arr = [];
        $('.parcel-checkbox:checked').each(function() {
            arr.push($(this).data('payment-status-id'));
            
        });

        if(arr.includes(2)){
            alert('Remember to select only unpaid parcels');
            // $('#check-all').prop('checked', true);
        }
        else{
            if ($('.parcel-checkbox:checked').length >= 1) {
                $('.pay_btn').show();
            } else {
                $('.pay_btn').hide();
            }
        }
    });

    $(document).on('change', ".parcel-checkbox", function() {
        if ($('.parcel-checkbox:checked').length == $('.parcel-checkbox').length) {
            $('#check-all').prop('checked', true);
        } else {
            $('#check-all').prop('checked', false);
        }

        var payment_status_id = $(this).data('payment-status-id');

        if(payment_status_id == 1){
            if ($('.parcel-checkbox:checked').length >= 1) {
                $('.pay_btn').show();
            } else {
                $('.pay_btn').hide();
            }
        }else{
            alert('Remember to select only unpaid parcels');
            $('.parcel-checkbox').prop('checked', false);
        }

        
    });

    $(document).on('click', ".pay_btn", function() {

        var checkedCount = $('.parcel-checkbox:checked').length;
        if (checkedCount > 0) {

            var parcelIds = [];

            $('.parcel-checkbox:checked').each(function() {
                var id = $(this).data('parcel-id');
                parcelIds.push(id);
            });

            var data = {'parcelIds' : parcelIds} ;
            var url = "{{route('parcel.getPayParcelsData')}}";

            // Function to get html of Payment Data
            getHtmlAjax(url, "#ni-pay-parcel-modal", "#pay-parcel-body",data);

        } else {

            alert('Select any parcel');

        }

    });

    // Change Bulk Action
    $(document).on('change', "#ni-action", function() {

        let type = $(this).val();
        var checkedCount = $('.parcel-checkbox:checked').length;
        if (checkedCount > 0) {

            var parcelIds = [];

            $('.parcel-checkbox:checked').each(function() {
                var id = $(this).data('parcel-id');
                parcelIds.push(id);
            });

            switch (type) {
                case 'consolidate':
                    if (checkedCount > 1) {
                        bulkAction("{{route('consolidate.store')}}", parcelIds, "You want to move parcels to consolidate!")
                    } else {
                        alert('Select multiple parcels to consolidate');
                    }
                    break;
                case "draft-shipment":
                    bulkAction("{{route('parcel.toDraft')}}", parcelIds, "Move parcel to draft section!")
                    break;
                case "delete-shipment":
                    bulkAction("{{route('parcel.destroy')}}", parcelIds, "Move parcel to trash section!")
                    break;
                default:
                    // code block
            }

        } else {

            if (type != '--select--') {
                alert('Select any row');
            }

        }

    })


    function bulkAction(url, arr, text) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'mr-2 btn btn-danger'
            },
            buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, move it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var request = $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "arr": arr,
                    },
                    dataType: "json",
                });
                request.done(function(response) {
                    if (response.success) {
                        notify('success', response.success);
                    }
                    if (response.redirect) {
                        setTimeout(function() {
                            location.href = response.redirect
                        }, 1000);
                    }
                    if (parcelsTable == null) {

                    } else {
                        parcelsTable.draw();
                    }
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
    }

    // Change invoice status
    $(document).on('click', ".ni-invoice-status", function() {
        let id = $(this).data("parcel-id");
        if (id) {
            var url = "{{route('parcel.changeInvoiceStatus',['id' => ':id'])}}";
            url = url.replace(':id', id);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'mr-2 btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var request = $.ajax({
                        url: url,
                        method: "PUT",
                        data: {
                            "_token": "{{csrf_token()}}"
                        },
                        dataType: "json",
                    });
                    request.done(function(response) {
                        if (response.success) {
                            notify('success', response.success);
                        }
                        if (parcelsTable == null) {

                        } else {
                            parcelsTable.draw();
                        }
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
        }
    })

    // Consolidate Scripts 
    function consolidaTable(params = null) {

        consolidaTable = $('#consolidate-data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('consolidate.data')}}?user_id=" + "{{$user->id}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'invoice',
                    name: 'invoice'
                },
                {
                    data: 'waybill',
                    name: 'waybill'
                },
                {
                    data: 'sender',
                    name: 'sender'
                },
                {
                    data: 'reciever',
                    name: 'reciever'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'payment',
                    name: 'payment'
                },
                {
                    data: 'invoice_status',
                    name: 'invoice_status'
                },
                {
                    data: 'status',
                    name: 'status'
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
        let id = $(this).data("consolidate-id");
        if (id) {
            let url = "{{route('consolidate.getPaymentHtml',['id' => ':id'])}}";
            url = url.replace(':id', id);
            // Function to get html of Payment Data
            getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
        }

    })


    // Change invoice status
    $(document).on('click', ".ni-invoice-status", function() {
        let id = $(this).data("consolidate-id");
        if (id) {
            var url = "{{route('consolidate.changeInvoiceStatus',['id' => ':id'])}}";
            url = url.replace(':id', id);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'mr-2 btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var request = $.ajax({
                        url: url,
                        method: "PUT",
                        data: {
                            "_token": "{{csrf_token()}}"
                        },
                        dataType: "json",
                    });
                    request.done(function(response) {
                        if (response.success) {
                            notify('success', response.success);
                        }
                        if (consolidaTable == null) {

                        } else {
                            consolidaTable.draw();
                        }
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


        }

    })

    function walletTable(params = null) {

        walletTable = $('#wallet-data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('wallet.transaction.data')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'payment_method',
                    name: 'payment_method'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'total_converted',
                    name: 'total_converted'
                },
                {
                    data: 'payment_reciept',
                    name: 'payment_reciept'
                },
                {
                    data: 'status',
                    name: 'status'
                },

                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {
        let id = $(this).data("wallet-id");
        if (id) {
            let url = "{{route('wallet.getPaymentHtml',['id' => ':id'])}}";
            url = url.replace(':id', id);
            // Function to get html of Payment Data
            getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
        }

    })

    // Change wallet status
    $(document).on('click', ".approve-wallet", function() {
        let wallet_id = $(this).data("wallet-id");
        var url = "{{route('wallet.approve')}}";
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'mr-2 btn btn-danger'
            },
            buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to Approve this transaction",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var request = $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        wallet_id: wallet_id,
                    },
                    dataType: "json",
                });
                request.done(function(response) {
                    if (response.success) {
                        notify('success', response.success);
                    }
                    walletTable.draw();
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

    // Change wallet status
    // $(document).on('click', ".reject-wallet", function() {
    //     let wallet_id = $(this).data("wallet-id");
    //     var url = "{{route('wallet.reject')}}";
    //     const swalWithBootstrapButtons = Swal.mixin({
    //         customClass: {
    //             confirmButton: 'btn btn-success',
    //             cancelButton: 'mr-2 btn btn-danger'
    //         },
    //         buttonsStyling: false,
    //     })

    //     swalWithBootstrapButtons.fire({
    //         title: 'Are you sure?',
    //         text: "You want to reject this transaction",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Yes, reject it!',
    //         cancelButtonText: 'No, cancel!',
    //         reverseButtons: true
    //     }).then((result) => {
    //         if (result.value) {
    //             var request = $.ajax({
    //                 url: url,
    //                 method: "POST",
    //                 data: {
    //                     "_token": "{{csrf_token()}}",
    //                     wallet_id: wallet_id,
    //                 },
    //                 dataType: "json",
    //             });
    //             request.done(function(response) {
    //                 if (response.success) {
    //                     notify('success', response.success);
    //                 }
    //                 table.draw();
    //             });
    //             request.fail(function(jqXHR, textStatus) {
    //                 if (jqXHR.status == '422') {
    //                     notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
    //                 }
    //             });

    //         } else if (
    //             /* Read more about handling dismissals below */
    //             result.dismiss === Swal.DismissReason.cancel
    //         ) {
    //             swalWithBootstrapButtons.fire(
    //                 'Cancelled',
    //                 'Your imaginary data is safe :)',
    //                 'error'
    //             )
    //         }
    //     })

    // })

    $(document).on('click', ".reject-wallet", function() {
        let wallet_id = $(this).data("wallet-id");
        $('#wallet_id').val(wallet_id);
        $('#reject-modal').modal('show');

    })


    $(document).on('click', ".show_reason", function() {
        let reason = $(this).data("reason");
        $('#reject-form').html(reason);
        $('#reject-modal').modal('show');

    })

    $(document).on('click', "#reject-button", function() {

        let url = "{{route('wallet.reject')}}";
        let ModalId = "#reject-modal";
        let formId = "#reject-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId, walletTable)

    })

    $(document).on('click', "#proceed-to-pay", function() {

        let url = "{{route('parcel.pay.amount')}}";
        let ModalId = "#ni-pay-parcel-modal";
        let formId = "#parcel-payment-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId, parcelsTable)

    })
</script>
@endpush