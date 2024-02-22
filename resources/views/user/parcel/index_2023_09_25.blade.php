@extends('user.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcels</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
             <li class="breadcrumb-item"><a href="{{route('user.parcel.index')}}">Parcel</a></li>
            <li class="breadcrumb-item active"><a  href="{{route('user.parcel.create')}}">Create</a></li>
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
                                <th class="border">Image</th>
                                <th class="border">Sender</th>
                                <th class="border">Reciever</th>
                                <th class="border">Origin</th>
                                <th class="border">Destination</th>
                                <th class="border">Description</th>
                                <th class="border">Amounts</th>
                                <th class="border">Payments</th>
                                <th class="border">Invoice Status</th>
                                <th class="border">Order Invoice Status</th>
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


<div class="modal fade" id="receipt-modal" tabindex="-1" aria-labelledby="credit-debit-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title"> Add Bank Receipt</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="attachment-add-form" action="javascript:void(0)">
                <div class="modal-body">
                     @csrf
                       <input type="hidden" name="parchase_id" id="parchase_id">
                        <div class="col-6 col-xs-12 col-sm-12 mb-4">
                                <label><b>Receipt</b></label>
                             
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
       var config ="{{$status}}";
       var draft = "{{$drafted}}";
       var title = "{{$title}}";
        
        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('user.parcel.data')}}?drafted=" + draft + "&status=" + config + "&title=" + title,
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

    $(document).on('click', ".open-modalfor-addrec", function() {
           
         
     
            $('#parchase_id').val($(this).data('invoice-id'));
        //    var value = $(this).data("value");
        //    $('#accountTitle').text(value.toUpperCase());
        //    $('#status').val($(this).data("value"));
             $('#receipt-modal').modal('show');
           
           
     });
     $("#ni-payment-attach").change(function() {
        filePreview(this);
    });

    $(document).on('click', "#add-parcel-attachment", function() {
         
                // Collecting Current Form Data 
        forms = $("#attachment-add-form")[0];
        console.log(forms);
        var form = new FormData(forms);
      
        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('user.parcel.addReceipt')}}",
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
    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-attach-payment-add-preview').remove();

                if (input.files[0].type.indexOf('image') === 0) {
                  // If it's an image, display it in the file preview
                  $('#ni-payment-attach-append').html('<div class="text-start p-3 img-round"><img class="nl-attach-payment-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                } else {
                  // If it's not an image, display the document icon
                  $('#ni-payment-attach-append').html('<div class="text-start p-3 img-round"><img class="nl-attach-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
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