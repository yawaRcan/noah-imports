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
        <h3 class="text-themecolor mb-0">Currency</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Currency</li>
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
                            <h4 class="card-title mb-0">Currency</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect currency-data-add">Add Mode</button>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <!-- <h5 class="card-subtitle mb-3">Swipe Mode, ModeSwitch, Minimap, Sortable, SortableSwitch</h5> -->
                    <div class="table-responsive">
                        <table class="tablesaw table-bordered table-hover table no-wrap data-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                            <thead>
                                <tr>
                                    <th class="border"> No#</th>
                                    <th class="border"> Name</th>
                                    <th class="border"> Code</th>
                                    <th class="border"> Symbol</th>
                                    <th class="border">  Value</th>
                                    <th class="border">Created At</th>
                                    <th class="border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table></div> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-currency-edit" tabindex="-1" aria-labelledby="ni-currency-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="currency-edit">

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
<div class="modal fade" id="ni-currency-add" tabindex="-1" aria-labelledby="ni-currency-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="currency-add">

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

<script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
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
            ajax: "{{route('currency.data')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'symbol',
                    name: 'symbol'
                },
                {
                    data: 'value',
                    name: 'value'
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
    $(document).on('click', ".currency-data-edit", function() {
        let id = $(this).data("currency-id");
        let url = "{{route('currency.edit',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-currency-edit", "#currency-edit")
    })

    $(document).on('click', "#currency-edit-button", function() {

        let id = $(this).data("currency-id");
        let url = "{{route('currency.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-currency-edit";
        let formId = "#currency-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, ModalId, table)

    })

    $(document).on('click', ".currency-data-add", function() {
        let url = "{{route('currency.create')}}";
        getHtmlAjax(url, "#ni-currency-add", "#currency-add")
    })

    $(document).on('click', "#currency-add-button", function() {

        let url = "{{route('currency.store')}}";
        let ModalId = "#ni-currency-add";
        let formId = "#currency-add-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId,table)

    })

    $(document).on('click', ".currency-data-delete", function() {
        let id = $(this).data("currency-id");
        let url = "{{route('currency.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url,table)
    })
</script>
@endpush