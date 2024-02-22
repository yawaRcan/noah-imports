@extends('user.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcels</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Parcel</a></li>
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
                        <div class="col-md-6">
                            <label>Bulk Action</label>
                            <select id="ni-action" class="select2 form-control custom-select" style="width: 90%;">
                                <option value="--select--">-- Select --</option>
                                <option value="consolidate">Consolidate</option>
                                <option value="draft-shipment">Draft Shipment</option>
                            </select>
                            <div class="row mt-3">
                                <div class="col-4">
                                    <a href="javascript:void(0)" class="btn btn-light-primary text-info font-weight-medium waves-effect consolidate-parcels hide">
                                        Consolidate
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="javascript:void(0)" class="btn btn-light-warning text-success font-weight-medium waves-effect calculate-parcels hide">
                                        Calculate
                                    </a>
                                </div>
                                <div class="col-4"></div>
                            </div>



                        </div>
                        <div class="col-6 text-end">
                            <a href="{{route('user.parcel.create')}}" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Create Parcel</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-hover table no-wrape data-table">
                        <thead>
                            <tr>
                                <th class="border check-order"><input type="checkbox" id="check-all"></th>
                                <th class="border">No#</th>
                                <th class="border">Invoice</th>
                                <th class="border">Sender</th>
                                <th class="border">Reciever</th>
                                <th class="border">Origin</th>
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
<div class="modal fade" id="ni-parcel-tracking-modal" tabindex="-1" aria-labelledby="ni-parcel-tracking-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Shipment Tracking</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="parcel-tracking-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Add modal content -->
<div class="modal fade" id="ni-payment-change-modal" tabindex="-1" aria-labelledby="ni-payment-change-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Payment Receipt</h4>
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
<div class="modal fade" id="ni-calculate-parcel-modal" tabindex="-1" aria-labelledby="ni-calculate-parcel-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Calculate Parcel</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="calculate-parcel-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@push('footer-script')


<script>
    var table
    table();

    function table(params = null) {
       var config ="{{$status}}";
       var draft = "{{$drafted}}";
        
        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('user.parcel.data')}}?drafted=" + draft + "&status=" + config,
            "fnDrawCallback": function(param) {
                $('.check-order').removeClass('sorting sorting_asc sorting_desc');
            },
            columns: [
                {
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
                    data: 'sender',
                    name: 'sender'
                },
                {
                    data: 'reciever',
                    name: 'reciever'
                },
                {
                    data: 'origin',
                    name: 'origin'
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

    $('#check-all').change(function() {
        $('.parcel-checkbox').prop('checked', this.checked);

        if ($('.parcel-checkbox:checked').length > 1) {
            $('.consolidate-parcels').css('display', 'block');
            $('.calculate-parcels').css('display', 'block');
        } else {
            $('.consolidate-parcels').css('display', 'none');
            $('.calculate-parcels').css('display', 'none');
        }
    });

    $(document).on('change', ".parcel-checkbox", function() {
        if ($('.parcel-checkbox:checked').length == $('.parcel-checkbox').length) {
            $('#check-all').prop('checked', true);
        } else {
            $('#check-all').prop('checked', false);
        }

        // console.log($('.parcel-checkbox:checked').length);
        if ($('.parcel-checkbox:checked').length > 1) {
            $('.consolidate-parcels').css('display', 'block');
            $('.calculate-parcels').css('display', 'block');
        } else {
            $('.consolidate-parcels').css('display', 'none');
            $('.ccalculate-parcels').css('display', 'none');
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
                        bulkAction("{{route('user.consolidate.store')}}", parcelIds, "You want to move parcels to consolidate!")
                    } else {
                        alert('Select multiple parcels to consolidate');
                    }
                    break;
                case "draft-shipment":
                    bulkAction("{{route('user.parcel.toDraft')}}", parcelIds, "Move parcel to draft section!")
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


    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {
        let id = $(this).data("parcel-id");
        let url = "{{route('user.parcel.getPaymentHtml',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
    })

    // Opening of Tracking Modal
    $(document).on('click', ".ni-parcel-tracking", function() {
        let id = $(this).data("parcel-id");
        let url = "{{route('user.parcel.getTracking',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-parcel-tracking-modal", "#parcel-tracking-body")
    })

    $(document).on('click', ".consolidate-parcels", function() {

        var checkedCount = $('.parcel-checkbox:checked').length;
        if (checkedCount > 1) {

            var parcelIds = [];

            $('.parcel-checkbox:checked').each(function() {
                var id = $(this).data('parcel-id');
                parcelIds.push(id);
            });

            bulkAction("{{route('user.consolidate.store')}}", parcelIds, "You want to move parcels to consolidate!")

        } else {

            alert('Select more than 1 parcel to consolidate');

        }

    });

    $(document).on('click', ".calculate-parcels", function() {

        var checkedCount = $('.parcel-checkbox:checked').length;
        if (checkedCount > 0) {

            var parcelIds = [];

            $('.parcel-checkbox:checked').each(function() {
                var id = $(this).data('parcel-id');
                parcelIds.push(id);
            });

            var data = {'parcelIds' : parcelIds} ;
            var url = "{{route('user.parcel.calculateParcel')}}";

            // Function to get html of Payment Data
            getHtmlAjax(url, "#ni-calculate-parcel-modal", "#calculate-parcel-body",data);

        } else {

            alert('Select any parcel');

        }

    });

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
                    if (response.error) {
                        notify('error', response.error);
                    }
                    if (response.redirect) {
                        setTimeout(function() {
                            location.href = response.redirect
                        }, 1000);
                    }
                    if (table == null) {

                    } else {
                        table.draw();
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
        var url = "{{route('user.parcel.changeInvoiceStatus',['id' => ':id'])}}";
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
                    if (table == null) {

                    } else {
                        table.draw();
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

    })
</script>
@endpush