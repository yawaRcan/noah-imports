@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Wallet</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Transactions</a></li>
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
        <div class="col-12">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Transaction Requests</h4>
                        </div>
                        <div class="col-6 text-end">
                                <button class="btn btn-light-info text-info font-weight-medium waves-effect open-modal-button" data-value="credit">Credit</button>
                                <button class="btn btn-light-info text-info font-weight-medium waves-effect open-modal-button" data-value="debit">Debit</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-hover table no-wrape data-table">
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
</div>

<div class="modal fade" id="credit-debit-modal" tabindex="-1" aria-labelledby="credit-debit-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="accountTitle"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="credit-debit-form" action="javascript:void(0)">
                <div class="modal-body">
                     @csrf
                    
                     <input type="hidden" id="status" name="status" value=""  />
                        <div class="col-6 col-xs-12 col-sm-12 mb-4">
                                <label><b>User</b></label>
                             
                                <div class="input-group mb-3">
                             
                                    <select name="user_id" id="ni-reciver-ship-address" class="select2 form-control custom-select" style="width: 90%;">
                                    <option value="">Select User</option>
                                    @if($users->count()>0)
                                        @foreach($users as $key => $user)
                                            <option  value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                            
                        </div>
                        
                        <div class="col-6 col-xs-12 col-sm-12 mb-4">
                                <label><b>Payment Mehtod</b></label>
                             
                                <div class="input-group mb-3">
                                
                                    <select name="payment_method" id="ni-reciver-ship-address" class="select2 form-control custom-select" style="width: 90%;">
                                    <option value="">Payment method</option>
                                    @if(count($paymentMethods)>0)
                                        @foreach($paymentMethods as $key => $value)
                                            <option  value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                               
                        </div>
                        <div class="col-6 col-xs-12 col-sm-12 mb-4">
                                <label><b>Currency</b></label>
                             
                                <div class="input-group mb-3">
                                
                                    <select name="currency" id="ni-reciver-ship-address" class="select2 form-control custom-select" style="width: 90%;">
                                    <option value="">Currency</option>
                                    @if($currencies->count()>0)
                                        @foreach($currencies as $key => $currency)
                                            <option  value="{{$currency->id}}">{{$currency->name}}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                               
                        </div>
                        <div class="col-6 col-xs-12 col-sm-12 mb-4">
                            <div class="mb-3">
                                <label><b>Amount</b></label>
                                <div class="input-group mb-3">
                                   <input type="number" class="form-control" value="0"  name="deposit_amount" >
                                </div>
                            </div>
                        </div>
                     
                </div>
                <div class="modal-footer">
                    <div class=" text-end">
                         <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="credit-debit-submit">Submit</button>
                     </div>
                </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Reject Modal content -->
<div class="modal fade" id="reject-modal" tabindex="-1" aria-labelledby="reject-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Reason of rejection</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="reject-form" action="javascript:void(0)">
                <div class="modal-body">
                     @csrf
                     <input type="hidden" name="wallet_id" value="" id="wallet_id">
                     <div class="mb-3">
                         <label>Add Reason</label>
                         <textarea rows="5" cols="5" name="reason" id="reason" class="form-control"></textarea>
                     </div>
                </div>
                <div class="modal-footer">
                    <div class=" text-end">
                         <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="reject-button">Submit</button>
                     </div>
                </div>
             </form>
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
                <h4 class="modal-title" id="myLargeModalLabel">View Payment Receipt</h4>
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


<div class="modal fade" id="ni-payment-status-modal" tabindex="-1" aria-labelledby="ni-payment-status-modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">View Payment Status</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="payment-status-body">

            </div>
            <div class="modal-footer">
                <button type="button" id="print" class="btn btn-primary">Print</button>
                </button>
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
       var config ="{{$status}}";
        
        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('wallet.transaction.data')}}?status="+config,
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

        $(document).on('click', ".open-modal-button", function() {
           
           
            var value = $(this).data("value");
            $('#accountTitle').text(value.toUpperCase());
            $('#status').val($(this).data("value"));
            $('#credit-debit-modal').modal('show');
            
            
        })
       
        $(document).on('click', "#credit-debit-submit", function() {

            let url = "{{route('wallet.credit.debit')}}";
            let type = "POST";
            let formId = "#credit-debit-form";
            let ModalId="#credit-debit-modal"
            createFormAjax(url, type, formId, ModalId,table)  
        })

    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {
        let id = $(this).data("wallet-id");
        let url = "{{route('wallet.getPaymentHtml',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
    })

    $(document).on('click', ".show-receipt-status", function() {
        let id = $(this).data("wallet-id");
        let url = "{{route('wallet.getPaymentReceiptStatus',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-status-modal", "#payment-status-body")
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
                    if (response.html) {
                        $('#payment-status-body').html(response.html)
                        $('#ni-payment-status-modal').modal('show');
                    }
                    table.draw();
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
        createFormAjax(url, type, formId, ModalId,table)

    })


</script>
@endpush