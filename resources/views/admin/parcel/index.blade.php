@extends('admin.layout.master')

@section('content')
<style type="text/css">
    body {
        margin-top: 20px;
    }

    .steps .step {
        display: block;
        width: 100%;
        margin-bottom: 35px;
        text-align: center
    }

    .steps .step .step-icon-wrap {
        display: block;
        position: relative;
        width: 100%;
        height: 80px;
        text-align: center
    }

    .steps .step .step-icon-wrap::before,
    .steps .step .step-icon-wrap::after {
        display: block;
        position: absolute;
        top: 50%;
        width: 50%;
        height: 3px;
        margin-top: -1px;
        background-color: #e1e7ec;
        content: '';
        z-index: 1
    }

    .steps .step .step-icon-wrap::before {
        left: 0
    }

    .steps .step .step-icon-wrap::after {
        right: 0
    }

    .steps .step .step-icon {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        border: 1px solid #e1e7ec;
        border-radius: 50%;
        background-color: #f5f5f5;
        color: #374250;
        font-size: 38px;
        line-height: 81px;
        z-index: 5
    }

    .steps .step .step-title {
        margin-top: 16px;
        margin-bottom: 0;
        color: #606975;
        font-size: 14px;
        font-weight: 500
    }

    .steps .step:first-child .step-icon-wrap::before {
        display: none
    }

    .steps .step:last-child .step-icon-wrap::after {
        display: none
    }

    .steps .step.completed .step-icon-wrap::before,
    .steps .step.completed .step-icon-wrap::after {
        background-color: #0da9ef
    }

    .steps .step.completed .step-icon {
        border-color: #0da9ef;
        background-color: #0da9ef;
        color: #fff
    }

    @media (max-width: 576px) {

        .flex-sm-nowrap .step .step-icon-wrap::before,
        .flex-sm-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 768px) {

        .flex-md-nowrap .step .step-icon-wrap::before,
        .flex-md-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 991px) {

        .flex-lg-nowrap .step .step-icon-wrap::before,
        .flex-lg-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 1200px) {

        .flex-xl-nowrap .step .step-icon-wrap::before,
        .flex-xl-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    .bg-faded,
    .bg-secondary {
        background-color: #f5f5f5 !important;
    }
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcels</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            
            <li class="breadcrumb-item"><a href="{{route('parcel.index')}}">Parcel</a></li>
             @if($title=='Pending Parcels')
              @php
                $url=route('parcel.pendingParcels');
              @endphp
             @else
             @php
              $url=route('parcel.index');
              @endphp

             @endif
            <li class="breadcrumb-item active"><a href="{{$url}}">{{$title}}</a></li>
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
                        <div class="col-md-5">
                            <label>Bulk Action</label>
                            <select id="ni-action" class="select2 form-control custom-select">
                                <option value="--select--">-- Select --</option>
                                <option value="consolidate">Consolidate</option>
                                <option value="draft-shipment">Draft Shipment</option>
                                <option value="delete-shipment">Delete Shipment</option>
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
                        <div class="col-md-5">
                            <label>Parcel Status</label>
                            <select id="ni-action" class="select2 form-control custom-select parcel_status" style="width: 90%;">
                               <option value="--select--">-- Select --</option>
                               @foreach($configstatus as $id => $name)
                                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                         
                        </div>

                        <div class="col-md-2 text-end mt-1 mt-lg-0">
                            <a href="{{route('parcel.create')}}" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Create Parcel</a>
                        </div>
                    </div>
                    <!--   <div class="row">
                        
                    </div> -->
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped data-table">
                        <thead>
                            <tr>
                                <th class="border check-order"><input type="checkbox" id="check-all"></th>
                                <th class="border">No#</th>
                                <th>Image</th>
                                <th class="border">Invoice</th>
                                <th class="border">Sender</th>
                                <th class="border">Reciever</th>
                                <th class="border">Origin</th>
                                <th class="border">Destination</th>
                                <th class="border">Description</th>
                                <th class="border">Amounts</th>
                                <th class="border">Payments</th>
                                <th class="border">Invoice Status</th>
                                <th class="border">Order Receipt</th>
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
<div class="modal fade" id="ni-payment-change-modal" tabindex="-1" aria-labelledby="ni-payment-change-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Approve Payment</h4>
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
<div class="modal fade" id="ni-parcel-order-invoice" tabindex="-1" aria-labelledby="ni-parcel-order-invoice" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Parcel Order Invoice</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-invoice-change-body">

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
<!-- /.modal -->

<div class="modal fade" id="ni-order-invoice-change-modal" tabindex="-1" aria-labelledby="ni-payment-change-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="paymentReceiptStatus">Order Invoice Receipt</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-invoice-receipt-change-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Add modal content -->
<div class="modal fade" id="ni-parcel-order-invoice" tabindex="-1" aria-labelledby="ni-parcel-order-invoice" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Parcel Order Invoice</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-invoice-change-body">

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
<!-- /.modal -->


<div class="modal fade" id="receipt-modal" tabindex="-1" aria-labelledby="credit-debit-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title"> Add Order Invoice Receipt</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="attachment-add-form" action="javascript:void(0)">
                <div class="modal-body">
                     @csrf
                       <input type="hidden" name="parchase_id" id="parchase_id">
                        <div class="col-6 col-xs-12 col-sm-12 mb-4">
                                <label><b>Add Order Invoice</b></label>
                             
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                    <span class="mdi mdi-file-image"></span>
                                    </span>
                                    <input type="file" class="form-control" name="payment_file" id="ni-payment-attach">
                                </div>
                                <div class="col-12" id="ni-payment-attach-append">

                                </div> 
                        </div>
                </div>
                <div class="modal-footer">
                    <div class=" text-end">
                         <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="add-parcel-attachment">Submit</button>
                     </div>
                </div>
             </form>
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
        var config = "{{$status}}";
        var draft = "{{$drafted}}";
        var title = "{{$title}}";
        

        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('parcel.data')}}?drafted=" + draft + "&status=" + config+ "&title=" + title,
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
                    data: 'image',
                    name: 'image'
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
                    data: 'order_invoice_status',
                    name: 'order_invoice_status'
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

    $(document).on('click', ".ni-payment-order-invoice", function() {
    
        let id = $(this).data("parcel-id");
     
    
        let url = "{{route('parcel.getOrderInvoiceHtml',['id' => ':id'])}}";
        url = url.replace(':id', id);
        
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-order-invoice-change-modal", "#order-invoice-receipt-change-body")


    })
    $('.parcel_status').on('change', function() {
        // value="--select--"
        var selectedValue="--select--";
        var ParcelStatusId = $(this).val();
        var checkboxes = $('input[name="parcelRows[]"]:checked').map(function() {
            return this.value;
        }).get();

      $.ajax({

            url: "{{route('parcel.updateParcelStatus')}}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                parcelIds: checkboxes,
                parcelstatus_id:ParcelStatusId
            },
            success: function(response) {

                if (response.success) {
                    $(".parcel_status").val(selectedValue);
                       notify('success', response.success);
                       table.draw();
            
                    }
                // console.log("response",response);
                //alert('Checkboxes updated successfully');
            },
            error: function(xhr) {
                notify('error', 'please select parcel in the table');
                
            }
        });
      

    });  


    // Opening of Payment Modal
    $(document).on('click', ".ni-payment-show-modal", function() {
       
        let id = $(this).data("parcel-id");
        let url = "{{route('parcel.getPaymentHtml',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-payment-change-modal", "#payment-change-body")
    })
    $(document).on('click', ".ni-payment-show-order-modal", function() {
        
       
       let id = $(this).data("parcel-id");
       let url = "{{route('parcel.showParcelOrderInvoice',['id' => ':id'])}}";
       url = url.replace(':id', id);
       // Function to get html of Payment Data
       getHtmlAjax(url, "#ni-parcel-order-invoice", "#order-invoice-change-body")
   })

    // Opening of Tracking Modal
    $(document).on('click', ".ni-parcel-tracking", function() {
       
        let id = $(this).data("parcel-id");
        let url = "{{route('parcel.getTracking',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Payment Data
        getHtmlAjax(url, "#ni-parcel-tracking-modal", "#parcel-tracking-body")
    })

    // checking checkboxes
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
                    console.log('yes console');
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

    $(document).on('click', ".open-modalfor-addrec", function() {


           
           $('#parchase_id').val($(this).data('invoice-id'));

   
            $('#receipt-modal').modal('show');
          
          
    });

    $(document).on('click', "#add-parcel-attachment", function() {
         
         // Collecting Current Form Data 
 forms = $("#attachment-add-form")[0];
 console.log(forms);
 var form = new FormData(forms);

 // Running Reciever adding ajax request
 var request = $.ajax({
    
     url: "{{route('parcel.addOrderReceipt')}}",
     method: "POST",
     headers: {
         'X-CSRF-TOKEN': "{{csrf_token()}}"
     },
     processData: false,
     contentType: false,
     data: form,
 });
 // Ajaxt on Done Section here
 request.done(function(response) {

     $("#receipt-modal").modal('hide');
     if (response.success) {
        
         notify('success', response.success);
         table.draw();
     
       
     }
     // Hiding Current modal
     $("#ni-reciver-address-add-modal").modal('hide');
      
     // Empty the current modal
     $('.modal-body').html('');
     // Appending values to Reciever address Select data
     if (response.value) {
         var newOption = new Option(response.value.name, response.value.id, false, false);
         $('#ni-reciver-ship-address').append(newOption).trigger('change');
     }

 });
 request.fail(function(jqXHR, textStatus) {
     // Toaster on Error like validation
     if (jqXHR.status == '422') {
         notify('error', "The Given Data Is Invalid");
         $('.invalid-feedback').remove()
         $(":input").removeClass('is-invalid')
         var errors = jqXHR.responseJSON.errors;
         $.each(errors, function(index, value) {
             if ($("input[name=" + index + "]").length) {
                 $("input[name=" + index + "]").addClass('is-invalid');
                 $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
             }


             if ($("select[name=" + index + "]").length) {
                 $("select[name=" + index + "]").addClass('is-invalid');
                 $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
             }

             if ($("textarea[name=" + index + "]").length) {
                 $("textarea[name=" + index + "]").addClass('is-invalid');
                 $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
             }

         });
     }
 });
          

});

    $(document).on('click', ".consolidate-parcels", function() {

        var checkedCount = $('.parcel-checkbox:checked').length;
        if (checkedCount > 1) {

            var parcelIds = [];

            $('.parcel-checkbox:checked').each(function() {
                var id = $(this).data('parcel-id');
                parcelIds.push(id);
            });

            bulkAction("{{route('consolidate.store')}}", parcelIds, "You want to move parcels to consolidate!")

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
            var url = "{{route('parcel.calculateParcel')}}";

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