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
        <h3 class="text-themecolor mb-0">Shipping Adresses</h3>
        <!-- <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Address</li>
        </ol> -->
    </div>
    <!-- <div class="col-md-7 col-12 align-self-center d-none d-md-block">
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
    </div> -->
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
                            <h4 class="card-title mb-0">Shipping Adresses</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{route('shipping-address.create')}}" class="btn btn-light-info text-info font-weight-medium waves-effect">Add</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($shippingAddresses as $shippingAddress)
                        <div class="col-md-6 col-sm-12">
                            <div class="card card-hover">
                                <div class="card-header">
                                    <h4 class="mb-0 text-dark">{{$shippingAddress->first_name}} {{$shippingAddress->last_name}}</h4>
                                </div>
                                <div class="card-body"> 
                                    <p class="card-text">{{$shippingAddress->address}}</p>
                                    <a class="card-text">{{$shippingAddress->email}} </a>
                                    <p class="card-text">({{$shippingAddress->country_code}}) {{$shippingAddress->phone}}</p>
                                    <div class="row">
                                        <div class="col-6 text-start">
                                            <a href="{{route('shipping-address.edit', ['id' => $shippingAddress->id])}}" style="font-size:20px">
                                            <i class="me-2 mdi mdi-table-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 text-end">
                                            <a href="javascript:void(0)"  class="text-danger shipping-data-delete" href="#" data-shipping-id="{{$shippingAddress->id}}" style="font-size:20px">
                                            <i class="me-2 mdi mdi-delete"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')

<script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script>
    $(document).on('click', ".shipping-data-delete", function() {
        let id = $(this).data("shipping-id");
        let url = "{{route('shipping-address.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url)
    })
</script>
@endpush