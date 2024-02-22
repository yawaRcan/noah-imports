@extends('admin.layout.master')

@section('content') 
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Shipment</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Shipment Mode</li>
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
                            <h4 class="card-title mb-0">Shipment Mode</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Add Mode</button>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <!-- <h5 class="card-subtitle mb-3">Swipe Mode, ModeSwitch, Minimap, Sortable, SortableSwitch</h5> -->
                   <div class="table-responsive">
                        <table class="table  table-striped data-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                            <thead>
                                <tr>
                                    <th class="border">  No#</th>
                                    <th class="border"> Name</th>
                                    <th class="border">Created At</th>
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
<div class="modal fade" id="ni-shipment-mode-edit" tabindex="-1" aria-labelledby="ni-shipment-mode-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="shipmode-edit">

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
<div class="modal fade" id="ni-shipment-mode-add" tabindex="-1" aria-labelledby="ni-shipment-mode-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Shipment Mode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="shipmode-add">

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
   function table(params=null) {
          table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('shipment-mode.data')}}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'}, 
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
   }

   $(document).on('click',".shipmode-data-edit", function() {
   let id = $(this).data("shipmode-id"); 
    let url = "{{route('shipment-mode.edit',['id' => ':id'])}}";
    url = url.replace(':id', id); 
    getHtmlAjax(url,"#ni-shipment-mode-edit","#shipmode-edit")
})

$(document).on('click', "#shipmode-edit-button", function() {

    let id = $(this).data("shipmode-id");
    let url = "{{route('shipment-mode.update',['id' => ':id'])}}";
    url = url.replace(':id', id); 
    let ModalId = "#ni-shipment-mode-edit";
    let formId = "#shipmode-edit-form";
    let type = "PUT";
    updateFormAjax(url,type,formId,ModalId,table) 
     
})

$(document).on('click',".shipmode-data-add", function() { 
    let url = "{{route('shipment-mode.create')}}"; 
    getHtmlAjax(url,"#ni-shipment-mode-add","#shipmode-add")
})

$(document).on('click', "#shipmode-add-button", function() {

let url = "{{route('shipment-mode.store')}}"; 
let ModalId = "#ni-shipment-mode-add";
let formId = "#shipmode-add-form";
let type = "POST";
createFormAjax(url,type,formId,ModalId,table)

 
})
 
$(document).on('click',".shipmode-data-delete", function() {
    let id = $(this).data("shipmode-id");
    let url = "{{route('shipment-mode.destroy',['id' => ':id'])}}";
    url = url.replace(':id', id); 
    deleteAjax(url,table) 
})

</script>
@endpush