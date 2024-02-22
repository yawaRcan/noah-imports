@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcels</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Parcel</a></li>
            <li class="breadcrumb-item active">Edit Shipment</li>
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
            <form class="form-horizontal" id="parcel-edit-form" action="javascript:void(0)">
                @csrf
                <input type="hidden" name="search_user_id" value="{{$parcels->user_id}}" id="ni-search_id">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title mb-0">Edit Shipment</h4>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect" id="ni-reciver-address-add">Add Reciever Address</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Full Name</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-account-check"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcels->user->first_name}} {{$parcels->user->last_name}}" name="full_name" id="ni-full-name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Reciever's Address</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-account-location"></span>
                                    </span>
                                    <select name="reciver_ship_address" id="ni-reciver-ship-address" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Reciever's Address</option>
                                        @foreach($shipmentAddressRecive as $val)
                                        @if($parcels->reciever_address_id == $val->id)
                                        <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                        @else
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Sender's Address</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-map-marker-multiple"></span>
                                        </span>
                                        <select name="sender_ship_address" id="ni-sender-ship-address" class="select2 form-control custom-select" style="width: 90%;">

                                            @foreach($shipmentAddress as $val)
                                            @if($parcels->sender_address_id == $val->id)
                                            <option value="{{$val->id}}" selected>{{$val->first_name}} {{$val->last_name}}</option>
                                            @else
                                            <option value="{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Branch Destination's</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-map"></span>
                                    </span>
                                    <select name="branch_id" id="ni-branch-id" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Branch Destination's</option>
                                        @foreach($branches as $key => $val)
                                        @if($parcels->branch_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>From Country</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-map-marker-radius"></span>
                                        </span>
                                        <select name="from_country" id="ni-from-country" class="select2 form-control custom-select" style="width: 90%;">

                                            @foreach($countries as $key => $val)
                                            @if($parcels->from_country_id == $key)
                                            <option value="{{$key}}" selected>{{$val}}</option>
                                            @else
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>To Country</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-map-marker-radius"></span>
                                    </span>
                                    <select name="to_country" id="ni-to-country" class="select2 form-control custom-select" style="width: 90%;">

                                        @foreach($countries as $key => $val)
                                        @if($parcels->to_country_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>External Shipper</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-server"></span>
                                        </span>
                                        <select name="external_shpper" id="ni-external-shpper" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="" data-image="{{asset('assets/icons/select_default.png')}}">Select External Shipper</option>
                                            @foreach($externalShipper as $key => $val)
                                            @if($parcels->external_shipper_id == $val->id)
                                            <option value="{{$val->id}}" data-image="{{asset('assets/icons')}}/{{$val->icon}}" selected>{{$val->name}}</option>
                                            @else
                                            <option value="{{$val->id}}" data-image="{{asset('assets/icons')}}/{{$val->icon}}">{{$val->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Freight Type</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-speedometer"></span>
                                    </span>
                                    <select name="freight_type" id="ni-freight-type" class="select2 form-control custom-select" style="width: 90%;">

                                        <option value="sea-freight" @if($parcels->freight_type == "sea-freight") selected @endif >Sea Freight</option>
                                        <option value="air-freight" @if($parcels->freight_type == "air-freight") selected @endif >Air Freight</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Shipment Type</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-wallet-membership"></span>
                                        </span>
                                        <select name="shipment_type" id="ni-shipment-type" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select Shipment Type</option>
                                            @foreach($shipmentTypes as $key => $val)
                                            @if($parcels->shipment_type_id == $key)
                                            <option value="{{$key}}" selected>{{$val}}</option>
                                            @else
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Shipment Mode</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-wan"></span>
                                    </span>
                                    <select name="shipment_mode" id="ni-shipment-mode" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Shipment Mode</option>
                                        @foreach($shipmentMode as $key => $val)
                                        @if($parcels->shipment_mode_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Quantity</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcels->quantity}}" name="quantity" id="ni-quantity">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Weight (LBS)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-weight-kilogram"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$parcels->weight}}" name="weight" id="ni-weight">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Dimention</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$parcels->dimension}}" name="dimention" id="ni-dimention">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Length (Inch)</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-hololens"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcels->length}}" name="length_inch" id="ni-length-inch">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Width (Inch)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-panorama-wide-angle"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$parcels->width}}" name="width_inch" id="ni-width-inch">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Height (Inch)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-panorama-vertical"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$parcels->width}}" name="height_inch" id="ni-height-inch">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Product Description</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-sort-descending"></span>
                                        </span>
                                        <textarea class="form-control" name="product_desc" id="ni-product-desc">{{$parcels->product_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Delivery Fees</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcels->delivery_fee}}" name="delivery_fees" id="ni-delivery-fees">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 text-start">
                                        <label>OB ( % )</label>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-comment-alert-outline"></span>
                                    </span>
                                    <select name="ob_fees" id="ni-ob-fees" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select OB Fees</option>
                                        <option value="1" @if($parcels->ob_fees == 1) selected @endif >0 %</option>
                                        <option value="6" @if($parcels->ob_fees == 6) selected @endif >6 %</option>
                                        <option value="9" @if($parcels->ob_fees == 9) selected @endif >9 %</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Item Value</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcels->item_value}}" name="item_value" id="ni-item-value">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>External Waybill</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcels->external_waybill}}" name="external_awb" id="ni-external-awb">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 text-start">
                                        <label>Parcel Discount</label>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="mdi mdi-autorenew" id="ni-change-discount" style="font-size:20px;cursor:pointer;"></span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-comment-alert-outline"></span>
                                    </span>
                                    <select name="discount_type" id="ni-discount-type" class="select2 form-control custom-select" style="width: 90%;">
                                        <!-- <option value="">Select Discount</option> -->
                                        @if($parcels->discount_type == 'ship')
                                        <option value="ship" selected id="ni-ship-percentage">Shipment Discount ( {{$parcels->discount ?? 0}} )</option>
                                        <option value="total" id="ni-total-percentage">Total Discount ( 0 )</option>
                                        @endif
                                        @if($parcels->discount_type == 'total')
                                        <option value="ship" id="ni-ship-percentage">Shipment Discount ( 0 )</option>
                                        <option value="total" selected id="ni-total-percentage">Total Discount ( {{$parcels->discount ?? 0}} )</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Tax</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-percent"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$parcels->tax}}" name="tax" id="ni-tax">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Upload Images</label>
                                    <div class="dropzone" id="myDropzone">

                                    </div>
                                    <input type="hidden" id="files-main-id">
                                </div>
                            </div>
                            <div class="col-12" id="ni-images-append">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Parcel Status</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-verified"></span>
                                        </span>
                                        <select name="parcel_status" id="ni-parcel-status" class="select2 form-control custom-select" style="width: 90%;">
                                            <option value="">Select Parcel Status</option>
                                            @foreach($parcelStatus as $key => $val)

                                            @if($parcels->parcel_status_id == $val->id)
                                            <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                            @else
                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                            @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Import Duties</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-console"></span>
                                    </span>
                                    <select name="import_duties" id="ni-import-duties" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Import Duties</option>
                                        @foreach($importDuties as $key => $val)

                                        @if($parcels->import_duty_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>External Tracking</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-access-point-network"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$parcels->external_tracking}}" name="external_tracking" id="ni-external-tracking">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Estimate Delivery Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="estimate_delivery_date" value="{{$parcels->es_delivery_date}}" id="ni-estimate-delivery-date" placeholder="mm/dd/yyyy">
                                    <span class="input-group-text">
                                        <i data-feather="calendar" class="feather-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Comement</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-sort-descending"></span>
                                        </span>
                                        <textarea class="form-control" name="comment" id="ni-comment">{{$parcels->comment}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ni-important" name="important" class="material-inputs filled-in chk-col-blue" checked="">
                                    <label for="ni-important">Important</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ni-show-invoice" name="show_invoice" class="material-inputs filled-in chk-col-blue" checked="">
                                    <label for="ni-show-invoice">Show Invoice</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ni-show-delivery-date" name="show_delivery_date" class="material-inputs filled-in chk-col-blue" checked="">
                                    <label for="ni-show-delivery-date">Show Delivery Date</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="ni-hidden-pickup-station" value="{{$parcels->pickup_station_id ?? 0}}" name="pickup_station">
                    <input type="hidden" id="ni-hidden-discount" value="{{$parcels->discount}}" name="discount">
                    <div class="p-1 text-center">
                        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" data-parcel-id="{{$parcels->id}}" id="parcel-edit-button">Edit Shipment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>




<!-- Add modal content -->
<div class="modal fade" id="ni-reciver-address-add-modal" tabindex="-1" aria-labelledby="ni-reciver-address-add-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Reciever Address</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-reciver-address-body">

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
<div class="modal fade" id="ni-dicount-modal" tabindex="-1" aria-labelledby="ni-dicount-modal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="ni-discount-text">Parcel Discount</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ni-dicount-body">
                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <span class="mdi mdi-access-point-network"></span>
                        </span>
                        <input type="number" class="form-control ni-dicount-val" id="ni-dicount-val-ship" value="{{$parcels->discount_type == 'ship' ? $parcels->discount:0}}">
                        <input type="number" class="form-control ni-dicount-val" id="ni-dicount-val-total" value="{{$parcels->discount_type == 'total' ? $parcels->discount:0}}">
                    </div>
                </div>
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
    var myDropzone = '';
    // Select2 for form select fields
    $("#ni-sender-ship-address").select2();
    $("#ni-branch-id").select2();
    $("#ni-external-shpper").select2({
        templateResult: formatState,
        templateSelection: formatState
    });
    $("#ni-freight-type").select2();
    $("#ni-shipment-type").select2();
    $("#ni-shipment-mode").select2();
    $("#ni-from-country").select2();
    $("#ni-to-country").select2();
    jQuery('#ni-estimate-delivery-date').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    function formatState(opt) {
        if (!opt.id) {
            return opt.text.toUpperCase();
        }

        var optimage = $(opt.element).attr('data-image');

        if (!optimage) {
            return opt.text.toUpperCase();
        } else {
            var $opt = $(
                '<span><img src="' + optimage + '" width="40px" /> ' + opt.text.toUpperCase() + '</span>'
            );
            return $opt;
        }
    };

    // Opening of User Reciever Address Modal
    $(document).on('click', "#ni-reciver-address-add", function() {
        let url = "{{route('user.parcel.getrecieverhtml')}}";
        // Function to get html of Reciever Address Form
        getHtmlAjax(url, "#ni-reciver-address-add-modal", "#ni-reciver-address-body")
        setTimeout(function() {
            $('#ni-reciever-user').val($("#ni-search_id").val())
        }, 1000);
    })

    // Action On Click Reciever Address Form Add Button
    $(document).on('click', "#ni-reciever-address-add-btn", function() {

        // Collecting Current Form Data 
        forms = $("#ni-reciever-address-add-form")[0];
        var form = new FormData(forms);

        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('user.parcel.addreciever')}}",
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

            if (response.success) {
                notify('success', response.success);
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
                    $("input[name=" + index + "]").addClass('is-invalid');
                    $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                });
            }
        });

    });

    $(document).on('click', "#parcel-edit-button", function() {
        let id = $(this).data("parcel-id");
        let url = "{{route('user.parcel.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#parcel-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, null, null, myDropzone)
    })

        // Click action on Delivery Method Field
    $(document).on('change', "#ni-delivery-method", function() {

        let value = $(this).val();
        if (value == 1) {
            if ($("#ni-hidden-pickup-station").val() == 0) {
                // Opening of Pickup Station Select Modal 
                let url = "{{route('parcel.getPickupStation')}}?parcel_id={{$parcels->id}}";
                // Function to get html of Pickup Station Modal 
                getHtmlAjax(url, "#ni-pickup-station-modal", "#ni-pickup-station-body")
                // Show pickup station change icon
                $("#ni-change-station").show()
            } else {
                // Opening of Pickup Station Select Modal 
                $("#ni-pickup-station-modal").modal('show')
                // Show pickup station change icon
                $("#ni-change-station").show()
            }
        } else {
            $("#ni-change-station").hide()
        }

    })
    $(document).on('change', "#ni-discount-type", function() {
        let val = $(this).val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'ship') {
                $('#ni-discount-text').html('Shipment Discount');
                $('#ni-dicount-val-total').hide();
                $('#ni-dicount-val-ship').show();
                $('#ni-ship-percentage').text('Shipment Discount ('+$('#ni-dicount-val-ship').val()+" )");
            } else {
                $('#ni-discount-text').html('Total Discount');
                $('#ni-dicount-val-ship').hide();
                $('#ni-dicount-val-total').show();
                $('#ni-total-percentage').text('Total Discount ('+$('#ni-dicount-val-total').val()+" )");
            }
            $('#ni-dicount-modal').modal('show')
        }
    })
    $(document).on('click', "#ni-change-discount", function() {
        let val = $('#ni-discount-type').val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'ship') {
                $('#ni-discount-text').html('Shipment Discount');
                $('#ni-dicount-val-total').hide();
                $('#ni-dicount-val-ship').show(); 
                $('#ni-ship-percentage').text('Shipment Discount ('+$('#ni-dicount-val-ship').val()+" )");
            } else {
                $('#ni-discount-text').html('Total Discount');
                $('#ni-dicount-val-ship').hide();
                $('#ni-dicount-val-total').show();
                $('#ni-total-percentage').text('Total Discount ('+$('#ni-dicount-val-total').val()+" )");
            }
            $('#ni-dicount-modal').modal('show')
        }
    })
    $(document).on('change', ".ni-dicount-val", function() {
        $("#ni-hidden-discount").val($(this).val());
    })

    $(document).on('keyup', "#ni-dicount-val-ship", function() {
        let val = $('#ni-discount-type').val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'ship') { 
                $('#ni-ship-percentage').text('Shipment Discount ('+$('#ni-dicount-val-ship').val()+" )");
            }   
        }
    })

    $(document).on('keyup', "#ni-dicount-val-total", function() {
        let val = $('#ni-discount-type').val();

        if (val != '' && val != 'undefined' && val != null) {
            if (val == 'total') { 
                $('#ni-total-percentage').text('Total Discount ('+$('#ni-dicount-val-total').val()+" )");
            }   
        }
    })

    Dropzone.options.myDropzone = {
        autoProcessQueue: false,
        uploadMultiple: true,
        addRemoveLinks: true,
        maxFilesize: 10,
        maxFiles: 10,
        parallelUploads: 10,
        paramName: "file",
        acceptedFiles: 'image/*',
        url: "{{ route('user.parcel.file.store') }}",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Drag and drop files here or click to upload',
        dictFallbackMessage: 'Your browser does not support drag and drop file uploads.',
        init: function() {
            myDropzone = this;
            myDropzone.on('sending', function(file, xhr, formData) {
      
                var id = $('#files-main-id').val();
                formData.append('parcel_id', id);
            });
            myDropzone.on("success", function(file, response) {
                setTimeout(function() {
                    location.href = "{{route('user.parcel.index')}}"
                }, 1000);
            });
            myDropzone.on("removedfile", function(file) {
                var previewElement = file.previewElement;
                if (previewElement) {
                    previewElement.parentNode.removeChild(previewElement);
                }
            });

        }
    };
</script>
@endpush