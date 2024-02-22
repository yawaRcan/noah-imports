@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Branches</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Branch</li>
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
                            <h4 class="card-title mb-0">Branches</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect branch-data-add">Add Mode</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="pagination-data">
                    <div class="row">
                        @foreach($Branch as $bran)
                        <div class="col-md-5 col-sm-12">
                            <div class="card card-hover">
                                <div class="card-header">
                                    <h4 class="mb-0 text-dark">{{$bran->name}}</h4>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{$bran->address}}</p>
                                    <a class="card-text">{{$bran->email}} </a>| <a class="card-text">{{$bran->country_code}}-{{$bran->phone}}</a>
                                    <p class="card-text">Currency: {{$bran->currency->name ?? ''}} {{$bran->currency->code ?? ''}}</p>
                                    <p class="card-text">Pickup {{$bran->currency->code ?? ''}}{{$bran->pickup_fee}}</p>
                                    <div class="row">
                                        <div class="col-6 text-start">
                                            <a href="javascript:void(0)" class="branch-data-edit" href="#" data-branch-id="{{$bran->id}}" style="font-size:20px">
                                                <i class="me-2 mdi mdi-table-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-6 text-end">
                                            <a href="javascript:void(0)" class="text-danger branch-data-delete" href="#" data-branch-id="{{$bran->id}}" style="font-size:20px">
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
                        {!! $Branch->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit modal content -->
<div class="modal fade" id="ni-branch-edit" tabindex="-1" aria-labelledby="ni-branch-edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Branch</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="branch-edit">

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
<div class="modal fade" id="ni-branch-add" tabindex="-1" aria-labelledby="ni-branch-add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">Add Branch</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="branch-add">

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

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        pagination(page);
    });

    function pagination(page) {
        $.ajax({
            url: "{{route('branch.index')}}?page=" + page,
            success: function(data) {
                $('#pagination-data').html(data);
            }
        });
    }

    $(document).on('click', ".branch-data-edit", function() {
        let id = $(this).data("branch-id");
        let url = "{{route('branch.edit',['id' => ':id'])}}";
        url = url.replace(':id', id);
        getHtmlAjax(url, "#ni-branch-edit", "#branch-edit")
    })

    $(document).on('click', "#branch-edit-button", function() {

        let id = $(this).data("branch-id");
        let url = "{{route('branch.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-branch-edit";
        let formId = "#branch-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, ModalId, null)  
        // if($('#isvalid').val() == 'true'){
        //     updateFormAjax(url, type, formId, ModalId, null) 
        //     pagination(1)
        // }else{ 
        //     notify('error', "The phone number is invalid");
        // } 

        pagination(1)
    })

    $(document).on('click', ".branch-data-add", function() {
        let url = "{{route('branch.create')}}";
        getHtmlAjax(url, "#ni-branch-add", "#branch-add")
    })

    $(document).on('click', "#branch-add-button", function() {

        let url = "{{route('branch.store')}}";
        let ModalId = "#ni-branch-add";
        let formId = "#branch-add-form";
        let type = "POST";
        createFormAjax(url, type, formId, ModalId,null)     
        // if($('#isvalid').val() == 'true'){
        //     createFormAjax(url, type, formId, ModalId, null) 
        //     pagination(1)
        // }else{  
        //     notify('error', "The phone number is invalid");
        // } 
        
    })

    $(document).on('click', ".branch-data-delete", function() {
        let id = $(this).data("branch-id");
        let url = "{{route('branch.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url, null)
        pagination(1)
    })
</script>
@endpush