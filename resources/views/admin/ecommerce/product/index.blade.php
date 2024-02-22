@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Ecommerce</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Ecommerce</a></li>
            <li class="breadcrumb-item"><a href="{{route('product.index')}}">Products</a></li>
            <li class="breadcrumb-item active">All Products</li>
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
                            <h4 class="card-title mb-0">All Products</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{route('product.create')}}" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Add Product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-hover table no-wrape data-table">
                        <thead>
                            <tr>
                                <th class="border">No#</th>
                                <th class="border">Title</th>
                                <th class="border">stock</th>
                                <th class="border">Status</th>
                                <th class="border">Price</th>
                                <th class="border">category</th>
                                <th class="border">Sub Category</th>
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

@endsection

@push('footer-script')


<script>
    var table
    table();

    function table(params = null) {

        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('product.data')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'stock',
                    name: 'stock'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'sub_category',
                    name: 'sub_category'
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

    $(document).on('click', ".product-data-delete", function() {
        let id = $(this).data("product-id");
        let url = "{{route('product.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url, table)
    })
</script>
@endpush