@extends('user.layout.master')

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
                    <h6 class="mb-0"><small>Total Credit Amount</small></h6>
                    <h4 class="mt-0 text-info">${{$user->credit()}}</h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Total Debit Amount</small></h6>
                    <h4 class="mt-0 text-primary">${{$user->debit()}}</h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Remaining Balance</small></h6>
                    @if($user->balance() < 0)
                        <h4 class="mt-0 text-danger">ƒ {{$user->balance()}} ANG</h4>
                    @else
                        <h4 class="mt-0 text-primary">ƒ {{$user->balance()}} ANG</h4>
                    @endif
                </div>
                <div class="spark-chart">
                    <div id="balance"></div>
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
                            <h4 class="card-title mb-0">Transactions</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-info center-block" data-bs-toggle="modal" data-bs-target="#deposit-modal">Deposit</button>
                            <!-- <button type="button" class="btn btn-warning center-block" data-bs-toggle="modal" data-bs-target="#withdraw-modal">With Draw</button> -->
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-hover table no-wrape data-table">
                        <thead>
                            <tr>
                                <th class="border">No#</th>
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

<!-- Deposit Modal content -->
<div class="modal fade" id="deposit-modal" tabindex="-1" aria-labelledby="deposit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Deposit Amount</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="deposit-form" action="javascript:void(0)" enctype="multipart/form-data">
                <div class="modal-body">
                         @csrf
                         <div class="mb-3">
                            <label for="image">Payment Method</label>
                            <select class="form-control payment_method" name="payment_method">
                                <option value="">--Select Payment Method--</option>
                                @foreach($paymentMethods as $key => $val)
                                <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="mb-3">
                            <label for="image">Currency</label>
                            <select class="form-control" name="currency">
                                <option value="">--Select Currency--</option>
                                @foreach($currencies as $currency)
                                <option value="{{$currency->id}}">{{$currency->name}}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="mb-3">
                             <label>Amount</label>
                             <input type="number" class="form-control" name="deposit_amount" placeholder="Enter Amount">
                         </div>
                         
                         <div class="mb-3">
                            <div class="col-md-6">
                                <label for="image">Payment Reciept</label>
                                <input type="file" id="ni-payment-file" class="form-control" name="payment_receipt" accept="image/*">
                            </div>
                            

                            <div class="col-md-6" id="ni-payment-file-append">
                            </div>
                         </div>

                         
                         <div class="mb-3">
                             <label>Description</label>
                             <textarea rows="5" cols="5" name="deposit_desc" class="form-control"></textarea>
                         </div>
                </div>
                <div class="modal-footer">
                    <div class=" text-end">
                         <button type="type" class="btn btn-light-success text-success font-weight-medium waves-effect" id="deposit-button">Submit</button>
                     </div>
                </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Add modal content -->
<div class="modal fade" id="withdraw-modal" tabindex="-1" aria-labelledby="withdraw-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">With Draw Amount</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="withdraw-form" action="javascript:void(0)">
                <div class="modal-body">
                         @csrf
                         <div class="mb-3">
                             <label>Amount</label>
                             <input type="number" class="form-control" name="withdraw_amount" placeholder="Enter Amount">
                         </div>
                         <div class="mb-3">
                             <label>Description</label>
                             <textarea rows="5" cols="5" name="withdraw_desc" class="form-control"></textarea>
                         </div>
                </div>
                <div class="modal-footer">
                    <div class=" text-end">
                         <button type="type" class="btn btn-light-success text-success font-weight-medium waves-effect" id="withdraw-button">Submit</button>
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
                <div class="modal-body" id="reason_txt">
                </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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
<!-- /.modal -->
<!-- Add modal content -->

<!-- Edit modal content -->
<div class="modal fade" id="ni-wallet-edit" tabindex="-1" aria-labelledby="ni-user-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Wallet</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="wallet-edit">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




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
            ajax: "{{route('user.wallet.transaction.data')}}?status="+config,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
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

    $("#balance").sparkline([5,6,2,9,4,7,10,12],{type:"bar",height:"35",barWidth:"4",resize:!0,barSpacing:"4",barColor:"#1e88e5"})

    $(document).on('click', "#deposit-button", function() {

        let url = "{{route('user.wallet.deposit')}}";
        let ModalId = "#deposit-modal";
        let formId = "#deposit-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId,table)

    })

    $(document).on('click', "#wallet-edit-button", function() {

       
            let id = $(this).data("wallet-id");
            let url = "{{route('user.wallet.update',['id' => ':id'])}}";
            url = url.replace(':id', id);
            let ModalId = "#ni-wallet-edit";
            let formId = "#wallet-edit-form";
            let type = "PUT";
            updateFormAjax(url, type, formId, ModalId, table);

     })

    $(document).on('click', "#withdraw-button", function() {

        let url = "{{route('user.wallet.withdraw')}}";
        let ModalId = "#withdraw-modal";
        let formId = "#withdraw-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId,table)

    })

    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {
        let id = $(this).data("wallet-id");
        let url = "{{route('user.wallet.getPaymentHtml',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
    })

    $(document).on('click', ".show-receipt-status", function() {
        let id = $(this).data("wallet-id");
        let url = "{{route('user.wallet.getPaymentReceiptStatus',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-status-modal", "#payment-status-body")
    })

    $(document).on('click', ".show_reason", function() {
        let reason = $(this).data("reason");
        $('#reason_txt').html(reason);
        $('#reject-modal').modal('show');

    })

    $("#ni-payment-file").change(function() {
        filePreview(this);
    });

    $(document).on('click', ".wallet-data-edit", function() {
       
       let id = $(this).data("wallet-id");
       let url = "{{route('user.wallet.edit',['id' => ':id'])}}";
       url = url.replace(':id', id);
       getHtmlAjax(url, "#ni-wallet-edit", "#wallet-edit")
   })

    $(document).on('click', ".wallet-data-delete", function() {
        let id = $(this).data("wallet-id");
        
        let url = "{{route('user.wallet.delete',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url, table)
    })

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

                if (input.files[0].type.indexOf('image') === 0) {
                  // If it's an image, display it in the file preview
                  $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                } else {
                  // If it's not an image, display the document icon
                  $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }


</script>
@endpush