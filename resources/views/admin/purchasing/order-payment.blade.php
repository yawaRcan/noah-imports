@extends('admin.layout.master')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/dropzone/dist/min/dropzone.min.css')}}">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Order</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchasing</a></li>
            <li class="breadcrumb-item active">Payment</li>
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
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Billing Details</h4>
                        </div>
                        <div class="col-6 text-end">
                            <!-- <p class="card-title mb-0">Total Amount to be paid: <strong>ƒ {{$order->amount_converted}} ANG</strong></p> -->
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect billing-data-add" data-order-id="{{$order->id}}"><i class="fa fa-plus"></i>Add Charge</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive">

                        <!-- table head -->
                        <thead class="table-active">
                            <tr>
                                <th colspan="">
                                    <a href="javascript:void(0)" class="sort">Payment number</a>
                                </th>
                                <th colspan="">
                                    <a href="javascript:void(0)" class="sort">Date</a>
                                </th>
                                <th colspan="">
                                    <a href="javascript:void(0)" class="sort">Payment Method</a>
                                </th>
                                <th colspan="">
                                    <a href="javascript:void(0)" class="sort">Total Paid</a>
                                </th>
                                <th class="text-right" colspan="">
                                    <a href="javascript:void(0)" class="sort">Action</a>
                                </th>
                            </tr>
                        </thead>

                        <tbody id="billing-tbody">
                            @forelse($order->billing as $key => $billing)
                                <tr>
                                    <td>{{ ++$key}}</td>
                                    <td>{{ $billing->created_at->format('d-M-Y') }}</td>
                                    <td>{{ $billing->payment->name ?? 'N/A' }} <img class="ni-payment-show-modal" data-order-id="' . $row->id . '" src="{{asset('assets/icons')}}/{{$billing->payment->icon ?? ''}}" width="30px" /></td>
                                    <td>{{ $billing->order->currency->symbol ?? '' }} {{ $billing->paid_amount ?? '0.00' }}</td>
                                    <td>
                                        @if($billing->payment_invoice)
                                        <button class="btn btn-success btn-sm ni-payment-show-modal" title="View Receipt" data-billing-id="{{$billing->id}}"><i class="fas fa-receipt"></i></button>&nbsp;
                                        @endif
                                        <button class="btn btn-primary btn-sm billing-data-edit" title="Edit" data-billing-id="{{ $billing->id }}"><i class="fa fa-edit"></i></button>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm billing-data-delete" data-billing-id="{{ $billing->id }}"><i class="fa fa-trash"></i></button></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">No Payment Available!</td>
                                </tr>
                            @endforelse

                            <tr class="text-end">
                                <td colspan="4"><strong>Total Amount:</strong></td>
                                <td>
                                    <strong>{{$order->currency->symbol ?? ''}} {{number_format($order->total ?? '00.0',2)}}</strong>
                                </td>   
                            </tr>
                            <tr class="text-end">
                                <td colspan="4"><strong>Total Paid:</strong></td>
                                <td>
                                    <strong>{{$order->currency->symbol ?? ''}} {{number_format($order->total - $order->balance_due, 2)}}</strong>
                                </td>
                            </tr>
                            <tr class="text-end">
                                <td colspan="4"><strong>Balance Due:</strong></td>
                                <td>
                                    <strong>{{$order->currency->symbol ?? ''}} {{number_format($order->balance_due ?? '00.0',2)}}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-billing-edit" tabindex="-1" aria-labelledby="ni-billing-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Charge</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="billing-edit">

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
<div class="modal fade" id="ni-billing-add" tabindex="-1" aria-labelledby="ni-billing-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Charge</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="billing-add">
                 
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


@endsection

@push('footer-script')
<script>
    $('.select2').select2();

    $(document).on('click', ".billing-data-add", function() {

        let id = $(this).data("order-id");
        let url = "{{route('purchasing.charge.create',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-billing-add", "#billing-add")
    })

    $(document).on('click', "#billing-add-button", function() {

        let url = "{{route('purchasing.charge.store')}}";
        let ModalId = "#ni-billing-add";
        let formId = "#billing-add-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId,null) 
        
    })

    $(document).on('click', ".billing-data-edit", function() {
        let id = $(this).data("billing-id");
        let url = "{{route('purchasing.charge.edit',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-billing-edit", "#billing-edit")
    })

    $(document).on('click', "#billing-edit-button", function() {

        let id = $(this).data("billing-id");
        let url = "{{route('purchasing.charge.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-billing-edit";
        let formId = "#billing-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, ModalId, null)  
    })

    $(document).on('click', ".billing-data-delete", function() {
        let id = $(this).data("billing-id");
        let url = "{{route('purchasing.charge.delete',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url, null)
    })

    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {
        let id = $(this).data("billing-id");
        let url = "{{route('purchasing.getChargePaymentHtml',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
    })

</script>
@endpush