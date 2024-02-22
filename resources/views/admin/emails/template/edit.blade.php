@extends('admin.layout.master')

@section('content')
<!-- This Page CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Email Templates</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Email Template</a></li>
            <li class="breadcrumb-item active">Template Edit</li>
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
                            <h4 class="card-title mb-0">Template Edit</h4>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect payment-data-add">Add Mode</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="emailTemp-edit-form" action="javascript:void(0)">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Email Title</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-account-check"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$emailTemplate->subject}}"" name=" title" id="ni-title">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Email Subject</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-account-check"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$emailTemplate->subject}}" name="subject" id="ni-subject">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Email Notice</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-account-check"></span>
                                        </span>
                                        <textarea class="form-control" name="notice" id="ni-notice" placeholder="Type some text">{{$emailTemplate->notice}}</textarea> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="editor">
                                    <textarea class="summernote" name="body" style="margin-top: 30px;" placeholder="Type some text">
                                    {!! $emailTemplate->body !!}				
									 </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="p-1 text-center">
                            <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" data-emailTemp-id="{{$emailTemplate->id}}" id="emailTemp-edit-button" >edit Template</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('footer-script')
<!-- This Page JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            lang: ""
        });
    }); 
    $(document).on('click', "#emailTemp-edit-button", function() {
        var textareaValue = $('#summernote').summernote('code');
       
        let id = $(this).data("emailtemp-id"); 
        let url = "{{route('email.templates.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#emailTemp-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, null, null)

    })


</script>
@endpush