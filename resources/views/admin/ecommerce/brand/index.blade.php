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
            <li class="breadcrumb-item"><a href="javascript:void(0)">Brand</a></li>
            <li class="breadcrumb-item active">All Brands</li>
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
                            <h4 class="card-title mb-0">All Brands</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect brand-data-add">Add brand</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-hover table no-wrape data-table">
                        <thead>
                            <tr>
                                <th class="border">No#</th>
                                <th class="border">Title</th>
                                <th class="border">Slug</th> 
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
<div class="modal fade" id="ni-brand-edit" tabindex="-1" aria-labelledby="ni-brand-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit brand</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="brand-edit-body">

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
<div class="modal fade" id="ni-brand-add-modal" tabindex="-1" aria-labelledby="ni-brand-add-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add brand</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="brand-add-body">

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

        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('brand.data')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'slug',
                    name: 'slug'
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


    // Opening of Add Modal
    $(document).on('click', ".brand-data-add", function() {
        let url = "{{route('brand.create')}}";
        getHtmlAjax(url, "#ni-brand-add-modal", "#brand-add-body")
    })


    $(document).on('click', "#brand-add-button", function() {

        let url = "{{route('brand.store')}}";
        let ModalId = "#ni-brand-add-modal";
        let formId = "#brand-add-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, table)
    })

    $(document).on('click', ".brand-data-delete", function() {
        let id = $(this).data("brand-id");
        let url = "{{route('brand.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url, table)
    })

    $(document).on('click', ".brand-data-edit", function() {

        let id = $(this).data("brand-id");
        let url = "{{route('brand.edit',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-brand-edit", "#brand-edit-body")
    })

    $(document).on('click', "#brand-edit-button", function() { 
        let id = $(this).data("brand-id");
        let url = "{{route('brand.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-brand-edit";
        let formId = "#brand-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, table)
    })
</script>
@endpush