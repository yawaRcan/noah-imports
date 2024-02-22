@extends('admin.layout.master')

@section('content')
@push('head-script')
<link href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
@endpush
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Shipper Calculator</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Shipping Calculator</li>
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
                    <form class="form-horizontal" id="calculate-amount-form" action="javascript:void(0)">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Select Freight Type</label>
                            <div class="input-group mb-3 TypeResponsive">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="mdi mdi-speedometer"></span>
                                </span>
                                <select name="freight_type" id="ni-freight-type" class="select2 form-control custom-select" > 
                                    <option value="air-freight">Air Freight</option>
                                    <option value="sea-freight">Sea Freight</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Select Branch</label>
                            <div class="input-group mb-3 TypeResponsive">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="mdi mdi-map"></span>
                                </span>
                                <select name="branch_id" id="ni-branch-id" class="select2 form-control custom-select"> 
                                    @foreach($branches as $key => $val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>  
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Length (Inch)</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-hololens"></span>
                                        </span>
                                        <input type="text" class="form-control" value="0" name="length_inch" id="ni-length-inch">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Width (Inch)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-panorama-wide-angle"></span>
                                    </span>
                                    <input type="text" class="form-control" value="0" name="width_inch" id="ni-width-inch">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Height (Inch)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-panorama-vertical"></span>
                                    </span>
                                    <input type="text" class="form-control" value="0" name="height_inch" id="ni-height-inch">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Item Value</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="0" name="item_value" id="ni-item-value">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Import Duties</label>
                                    <div class="input-group mb-3 TypeResponsive">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <select name="import_duties" id="ni-import-duties" class="select2 form-control custom-select">
                             
                                            @foreach($importDuties as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-12 text-start">
                                        <label>OB ( % )</label>
                                    </div>
                                </div>
                                <div class="input-group mb-3 TypeResponsive">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-comment-alert-outline"></span>
                                    </span>
                                    <select name="ob_fees" id="ni-ob-fees" class="select2 form-control custom-select">
                        
                                        <option value="1">0 %</option>
                                        <option value="6">6 %</option>
                                        <option value="9" selected>9 %</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Weight (LBS)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-weight-kilogram"></span>
                                    </span>
                                    <input type="text" class="form-control" value="0" name="weight" id="ni-weight">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Dimention</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <input type="text" class="form-control" value="0" name="dimention" id="ni-dimention">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Chargable Weight</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-console"></span>
                                        </span>
                                        <input type="text" class="form-control" value="" name="chargable-weight" id="ni-chargable-weight" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-1 text-center">
                            <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="calculate-amount-button">Calculate Shipment</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-6" id="data-air-info">
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')

<script>
    $(document).on('click', "#calculate-amount-button", function() { 
        let formId = "#calculate-amount-form";
        let url = "{{route('shippingCalulator.store')}}"; 
        type = 'POST';
        forms = $(formId)[0];
        block("body");
        var form = new FormData(forms);
        var request = $.ajax({
            url: url,
            method: type,
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: form,
        });
        request.done(function(response) {
            unblock("body")
            if (response.success) {
                notify('success', response.success);
            }
            if (response.error) {
                notify('error', response.error);
            }

            if (response.html) {
                $('#' + response.html.selector).html(response.html.data)
            }


        });
        request.fail(function(jqXHR, textStatus) {
            unblock("body")
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
    })
</script>
@endpush