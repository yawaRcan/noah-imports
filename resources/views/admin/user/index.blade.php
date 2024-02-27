@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">User</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">User</li>
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
                            <h4 class="card-title mb-0">User List</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect user-data-add">Add User</button> 
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                        <!-- <h5 class="card-subtitle mb-3">Swipe Mode, ModeSwitch, Minimap, Sortable, SortableSwitch</h5> -->
                        <table class="tablesaw table-responsive table-bordered table-hover table no-wrap data-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                            <thead>
                                <tr>
                                    <th class="border"> No#</th>
                                    <th class="border"> Date</th>
                                    <th class="border"> NAME/CUSTOMER NO</th>
                                    <th class="border"> E-MAIL/PHONE</th>
                                    <th class="border"> INVITE NO:</th>
                                    <th class="border"> STATUS</th>
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
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-user-edit" tabindex="-1" aria-labelledby="ni-user-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="user-edit">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- ADD modal content -->
<div class="modal fade" id="ni-user-add" tabindex="-1" aria-labelledby="ni-user-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="user-add">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- Email modal content -->
<div class="modal fade" id="ni-user-email" tabindex="-1" aria-labelledby="ni-user-email" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="user-email">

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
            ajax: "{{route('user.val.data')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'invite_no',
                    name: 'invite_no'
                },
                {
                    data: 'status',
                    name: 'status'
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
    $(document).on('click', ".user-data-add", function() {
        let url = "{{route('user.val.addForm')}}";
        getHtmlAjax(url, "#ni-user-add", "#user-add")
    })
$(document).on('click', "#user-add-button", function() {
let id = $(this).data("user-id");
let url = "{{route('user.val.addUser')}}";
let ModalId = "#ni-user-add";
let formId = "#user-add-form";
let type = "PUT";
$("#ni-user-edit").modal('hide');
$("#user-edit-form").modal('hide');
updateFormAjax(url, type, formId, ModalId, table);


})


    $(document).on('click', ".user-data-edit", function() {
        let id = $(this).data("user-id");
        let url = "{{route('user.val.edit',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-user-edit", "#user-edit")
    })

    $(document).on('click', ".user-send-email", function() {
        let id = $(this).data("user-id");
        let url = "{{route('user.val.sendEmail',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-user-email", "#user-email")
    })

    $(document).on('click', "#user-email-button", function() {

        let id = $(this).data("user-id");
        let url = "{{route('user.val.postSendEmail',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-user-email";
        let formId = "#user-email-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId)

    })

    $(document).on('click', "#user-edit-button", function() {

        let id = $(this).data("user-id");
        let url = "{{route('user.val.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-user-edit";
        let formId = "#user-edit-form";
        let type = "PUT";
        $("#ni-user-edit").modal('hide');
        $("#user-edit-form").modal('hide');
        updateFormAjax(url, type, formId, ModalId, table);
        

    })


    $(document).on('click', ".user-data-delete", function() {
        let id = $(this).data("user-id");
        let url = "{{route('user.val.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url, table)
    })

</script>
@endpush