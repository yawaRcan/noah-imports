@extends('admin.layout.master')

@section('content') 
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">External Shipper</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active"> External Shipper</li>
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
                            <h4 class="card-title mb-0">External Shipper</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect exship-data-add">Add Mode</button>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <!-- <h5 class="card-subtitle mb-3">Swipe Mode, ModeSwitch, Minimap, Sortable, SortableSwitch</h5> -->
                  <div class="table-responsive">
                    <table class="table table-striped data-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                        <thead>
                            <tr>
                                <th class=""> No#</th>
                                <th class="">Name</th>
                                <th class="">Icon</th>
                                <th class="">Link</th>
                                <th class="">Slug</th>
                                <th class="">Created At</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                  </div>
                    <div class="d-flex justify-content-center">
                        {!! $ExternalShipper->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-external-shipper-edit" tabindex="-1" aria-labelledby="ni-external-shipper-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit External Shipper</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="exship-edit">

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
<div class="modal fade" id="ni-external-shipper-add" tabindex="-1" aria-labelledby="ni-external-shipper-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add External Shipper</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="exship-add">

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
            ajax: "{{route('external-shipper.data')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'icon',
                    name: 'icon'
                },
                {
                    data: 'link',
                    name: 'link'
                },
                {
                    data: 'slug',
                    name: 'slug'
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
    $(document).on('click', ".exship-data-edit", function() {
        let id = $(this).data("exship-id");
        let url = "{{route('external-shipper.edit',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-external-shipper-edit", "#exship-edit")
    })

    $(document).on('click', "#exship-edit-button", function() {

        let id = $(this).data("exship-id");
        let url = "{{route('external-shipper.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-external-shipper-edit";
        let formId = "#exship-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, table)

    })

    $(document).on('click', ".exship-data-add", function() {
        let url = "{{route('external-shipper.create')}}";
        getHtmlAjax(url, "#ni-external-shipper-add", "#exship-add")
    })

    $(document).on('click', "#exship-add-button", function() {

        let url = "{{route('external-shipper.store')}}";
        let ModalId = "#ni-external-shipper-add";
        let formId = "#exship-add-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId, table)

    })

    $(document).on('click', ".exship-data-delete", function() {
        let id = $(this).data("exship-id");
        let url = "{{route('external-shipper.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url, table)
    })
</script>
@endpush