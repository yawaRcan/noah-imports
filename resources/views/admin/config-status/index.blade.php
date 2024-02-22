@extends('admin.layout.master')

@section('content') 
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Parcel</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Parcel Status</li>
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
                            <h4 class="card-title mb-0">Parcel Status</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect constatus-data-add">Add Mode</button>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <!-- <h5 class="card-subtitle mb-3">Swipe Mode, ModeSwitch, Minimap, Sortable, SortableSwitch</h5> -->
                   <div class="table-responsive">
                    <table class="tablesaw table-bordered table no-wrap data-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border">
                                    No#</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border">
                                    Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3" class="border">Value</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3" class="border">Color</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3" class="border">Created At</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3" class="border">Action</th>
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
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-config-status-edit" tabindex="-1" aria-labelledby="ni-config-status-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="constatus-edit">

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
<div class="modal fade" id="ni-config-status-add" tabindex="-1" aria-labelledby="ni-config-status-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="constatus-add">

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
            ajax: "{{route('config-status.data')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'value',
                    name: 'value'
                },
                {
                    data: 'color',
                    name: 'color'
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
    $(document).on('click', ".constatus-data-edit", function() {
        let id = $(this).data("constatus-id");
        let url = "{{route('config-status.edit',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-config-status-edit", "#constatus-edit")
    })

    $(document).on('click', "#constatus-edit-button", function() {

        let id = $(this).data("constatus-id");
        let url = "{{route('config-status.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-config-status-edit";
        let formId = "#constatus-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, ModalId, table)

    })

    $(document).on('click', ".constatus-data-add", function() {
        let url = "{{route('config-status.create')}}";
        getHtmlAjax(url, "#ni-config-status-add", "#constatus-add")
    })

    $(document).on('click', "#constatus-add-button", function() {

        let url = "{{route('config-status.store')}}";
        let ModalId = "#ni-config-status-add";
        let formId = "#constatus-add-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId,table)

    })

    $(document).on('click', ".constatus-data-delete", function() {
        let id = $(this).data("constatus-id");
        let url = "{{route('config-status.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url,table)
    })
</script>
@endpush