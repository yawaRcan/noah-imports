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
            <li class="breadcrumb-item active">View Shipment</li>
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
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Invoice #{{$consolidate->invoice_no ?? 'N/A'}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Waybill: <span class="fw-bold">{{$consolidate->waybill ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Status : <span class="mb-1 badge text-white" style="background-color: {{$consolidate->parcelStatus->color  ?? 'N/A'}} ">{{$consolidate->parcelStatus->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            @if($consolidate->payment_status == 0)
                            <p class="card-text">Status : <span class="mb-1 badge bg-danger">Un Paid</span></p>
                            @else
                            <p class="card-text">Payment : <span class="mb-1 badge bg-success">Paid</span></p>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Shipment Type</p>
                            <p> <span class="card-text">{{$consolidate->shipmentType->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Shipment Mode</p>
                            <p> <span class="card-text">{{$consolidate->shipmentMode->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Freight Type</p>
                            <p> <span class="card-text">{{$consolidate->freight_type ?? 'N/A'}}</span></p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Amount</p>
                            <p> <span class="card-text">{{$consolidate->amount_total ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Payment Method</p>
                            <p> <span class="card-text">{{$consolidate->payment->name ?? 'N/A'}}</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="fw-bold">Estimated delivery date</p>
                            <p> <span class="card-text">{{$consolidate->es_delivery_date ?? 'N/A'}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Item description <a href="javascript:void(0)" class="btn btn-info ni-show-images p-1" data-consolidate-id="{{$consolidate->id}}">Show Images</a></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>Item Value</th>
                                    <th>Amount</th>
                                    <th>Quantity</th>
                                    <th>DESCRIPTION:</th>
                                    <th>CATEGORY</th>
                                    <th>WEIGHT (LB)</th>
                                    <th>LENGTH (INCH)</th>
                                    <th>WIDTH (INCH)</th>
                                    <th>HEIGHT (INCH)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parcels as $key => $parcel)
                                <tr id="consolidate-item-row-{{$parcel->id}}">
                                    <td>{{$parcel->item_value ?? 'N/A'}}</td>
                                    <td>{{number_format($total[$key], 2) ?? 'N/A'}}</td>
                                    <td>{{$parcel->quantity ?? 'N/A'}}</td>
                                    <td>{{$parcel->product_description ?? 'N/A'}}</td>
                                    <td>{{$parcel->duty->name ?? 'N/A'}} ({{$parcel->duty->value ?? '0'}}%)</td>
                                    <td>{{$parcel->weight ?? 'N/A'}}</td>
                                    <td>{{$parcel->length ?? 'N/A'}}</td>
                                    <td>{{$parcel->width ?? 'N/A'}}</td>
                                    <td>{{$parcel->height ?? 'N/A'}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-4">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Origin</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <p class="card-text">Country : <span class="fw-bold">{{$consolidate->toCountry->name ?? 'N/A'}}</span></p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Destination</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <p class="card-text">Name : <span class="fw-bold">{{$consolidate->branch->name ?? 'N/A'}}</span></p>
                    <p class="card-text">Phone : <span class="fw-bold">{{$consolidate->branch->phone ?? 'N/A'}}</span></p>
                    <p class="card-text">Country : <span class="fw-bold">{{$consolidate->branch->country ?? 'N/A'}}</span></p>
                    <p class="card-text">Address : <span class="fw-bold">{{$consolidate->branch->address ?? 'N/A'}}</span></p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-hover">
                <div class="card-header">
                    <h4 class="mb-0 text-dark">Delivery Address</h4>
                </div>
                <div class="card-body" style="height:250px">
                    <p class="card-text">Name : <span class="fw-bold">{{$consolidate->reciever->address ?? 'N/A'}}</span></p>
                    <p class="card-text">Phone : <span class="fw-bold">{{$consolidate->reciever->phone ?? 'N/A'}}</span></p>
                    <p class="card-text">Country : <span class="fw-bold">{{$consolidate->reciever->country->name ?? 'N/A'}}</span></p>
                    <p class="card-text">Address : <span class="fw-bold">{{$consolidate->reciever->address ?? 'N/A'}}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




<!-- Add modal content -->
<div class="modal fade" id="ni-show-images-modal" tabindex="-1" aria-labelledby="ni-show-images-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Reciever Address</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-show-images-modal-body">

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
    // Opening show Images Modal 
    $(document).on('click', ".ni-show-images", function() {
        let id = $(this).data("consolidate-id");
        let url = "{{route('user.consolidate.imagesGet',['id' => ':id'])}}";
        url = url.replace(':id', id);
        // Function to get html of Images Form
        getHtmlAjax(url, "#ni-show-images-modal", "#ni-show-images-modal-body")

    })

</script>
@endpush