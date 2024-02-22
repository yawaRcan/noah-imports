@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcels</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="{{route('parcel.index')}}">Parcel</a></li>
            <li class="breadcrumb-item active"><a href="{{route('parcel.archivedParcels')}}">{{$title}}</a></li>
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
                    <!--   <div class="row">
                        
                    </div> -->
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped data-table">
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
            ajax: "{{route('parcel.archivedParcels')}}",
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


    // checking checkboxes
    // $('#check-all').change(function() {
    //     $('.parcel-checkbox').prop('checked', this.checked);

    //     if ($('.parcel-checkbox:checked').length > 1) {
    //         $('.consolidate-parcels').css('display', 'block');
    //         $('.calculate-parcels').css('display', 'block');
    //     } else {
    //         $('.consolidate-parcels').css('display', 'none');
    //         $('.calculate-parcels').css('display', 'none');
    //     }
    // });

    // $(document).on('change', ".parcel-checkbox", function() {
    //     if ($('.parcel-checkbox:checked').length == $('.parcel-checkbox').length) {
    //         $('#check-all').prop('checked', true);
    //     } else {
    //         $('#check-all').prop('checked', false);
    //     }

    //     // console.log($('.parcel-checkbox:checked').length);
    //     if ($('.parcel-checkbox:checked').length > 1) {
    //         $('.consolidate-parcels').css('display', 'block');
    //         $('.calculate-parcels').css('display', 'block');
    //     } else {
    //         $('.consolidate-parcels').css('display', 'none');
    //         $('.ccalculate-parcels').css('display', 'none');
    //     }
    // });

</script>
@endpush