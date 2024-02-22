@extends('admin.layout.master')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/dropzone/dist/min/dropzone.min.css')}}">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Configurations</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
            <li class="breadcrumb-item active">Configuration</li>
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
                            <h4 class="card-title mb-0">Configurations</h4>
                        </div>
                        <div class="col-6 text-end">
                            <!-- <button type="button" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">Add Mode</button> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex active" data-bs-toggle="tab" href="#configurations" role="tab">
                                <span><i class="ti-home"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Configurations</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#company" role="tab">
                                <span><i class="ti-user"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Company</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#smtp" role="tab">
                                <span><i class="ti-user"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">SMTP</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#aftership" role="tab">
                                <span><i class="ti-user"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Aftership</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="configurations" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="configurations-edit-form" action="javascript:void(0)">
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">SITE NAME :</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="site_name" name="site_name" value="{{$Setting->configuration->site_name ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">STORE NAME:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="store_name" name="store_name" value="{{$Setting->configuration->store_name ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">SITE TITLE:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="site_title" name="site_title" value="{{$Setting->configuration->site_title ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">SITE DESCRIPTION:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="site_description" name="site_description" value="{{$Setting->configuration->site_description ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">FILE UPLOAD SIZE (MB) MAX:15MB:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="file_size" name="file_size" value="{{$Setting->configuration->file_size ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">DEFAULT CURRENCY</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="default_currency" name="default_currency" value="{{$Setting->configuration->default_currency ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">DEFAULT LANGUAGE</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="default_lang" name="default_lang" value="{{$Setting->configuration->default_lang ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">SITE STATUS</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="site_status" @if($Setting->configuration->site_status == 'on') checked @endif data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">CONSOLIDATE STATUS</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="consolidate_status" @if(@isset($Setting->configuration->consolidate_status) && $Setting->configuration->consolidate_status == 'on') checked @endif data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">EMAIL NOTIFICATION</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="email_notification" @if($Setting->configuration->email_notification == 'on') checked @endif data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">EMAIL VALIDATION</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="email_validation" @if($Setting->configuration->email_validation == 'on') checked @endif data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">ONLINE SHOP</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="online_shop" @if($Setting->configuration->online_shop == 'on') checked @endif data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">WATERMARK PROFILE PHOTO</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="water_photo" @if($Setting->configuration->water_photo == 'on') checked @endif data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">ALLOW SUB ICON</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="sub_icon" @if($Setting->configuration->sub_icon == 'on') checked @endif data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="configurations-edit-button" data-configurations-id="{{$Setting->id}}">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane  p-3" id="company" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="company-edit-form" action="javascript:void(0)" enctype="multipart/form-data"> 
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">Logo:</label>
                                        <div class="col-sm-3">
                                        <div class="nl-logo-file-edit-preview"></div>
                                        </div>
                                         <div class="col-sm-6">  
                                         <input type="file" id="nl-logo-edit-file" class="form-control" name="logo" placeholder="Upload logo">
                                         </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">FAVICON:</label>
                                        <div class="col-sm-3">
                                        <div class="nl-favicon-file-edit-preview"></div>
                                        </div>
                                         <div class="col-sm-6">  
                                         <input type="file" id="nl-favicon-edit-file" class="form-control" name="favicon" placeholder="Upload logo">
                                         </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">WATERMARK:</label>
                                        <div class="col-sm-3">
                                        <div class="nl-watermark-file-edit-preview"></div>
                                        </div>
                                         <div class="col-sm-6">  
                                         <input type="file" id="nl-watermark-edit-file" class="form-control" name="watermark" placeholder="Upload logo">
                                         </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">INVOICE:</label>
                                        <div class="col-sm-3">
                                        <div class="nl-invoice-file-edit-preview"></div>
                                        </div>
                                         <div class="col-sm-6">  
                                         <input type="file" id="nl-invoice-edit-file" class="form-control" name="invoice" placeholder="Upload logo">
                                         </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">ONLINE SHOP:</label>
                                        <div class="col-sm-3">
                                        <div class="nl-online-shop-file-edit-preview"></div>
                                        </div>
                                         <div class="col-sm-6">  
                                         <input type="file" id="nl-online-shop-edit-file" class="form-control" name="online_shop" placeholder="Upload logo">
                                         </div>
                                    </div>
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="company-edit-button" data-company-id="{{$Setting->id}}">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane  p-3" id="smtp" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="smtp-edit-form" action="javascript:void(0)">
                                <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">DRIVER:</label>
                                        <div class="col-sm-9">
                                            <select name="mail_driver" id="mail_driver" class="form-control">
                                                <option value="mail" selected>mail</option>
                                                <option value="smtp" >smtp</option>
                                            </select> 
                                        </div>
                                    </div>
                                <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">HOST:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="host" name="host" value="{{$Setting->smtp->host ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">PORT:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="port" name="port" value="{{$Setting->smtp->port ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">Encryption:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="mail_encryption" name="mail_encryption" value="{{$Setting->smtp->mail_encryption  ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div> 
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">USERNAME:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="username" name="username" value="{{$Setting->smtp->username ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">EMAIL:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="email" name="email" value="{{$Setting->smtp->email ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">PASSWORD:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="password" name="password" value="{{$Setting->smtp->password ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>  
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="smtp-edit-button" data-smtp-id="{{$Setting->id}}">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane  p-3" id="aftership" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="aftership-edit-form" action="javascript:void(0)">
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">AFTERSHIP API:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="aftership_api" name="aftership_api" value="{{$Setting->aftership->aftership_api ?? ''}}" placeholder="Value Here">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">AFTERSHIP API STATUS:</label>
                                        <div class="col-sm-9">
                                            <div class="mb-4 bt-switch">
                                                <input type="checkbox" name="status" @if($Setting->aftership->status == 'on') checked @endif  data-on-color="primary" data-off-color="danger">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="aftership-edit-button" data-aftership-id="{{$Setting->id}}">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('footer-script')
<script src="{{asset('assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js')}}"></script>
<script src="{{asset('assets/libs/dropzone/dist/min/dropzone.min.js')}}"></script>
<script>
    $(".bt-switch input[type='checkbox']").bootstrapSwitch();

    $(document).on('click', "#configurations-edit-button", function() {
        let id = $(this).data("configurations-id");
        let url = "{{route('settings.config',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-configurations-mode-edit";
        let formId = "#configurations-edit-form";
        let type = "PUT";
        updateFormAjax(url, type, formId, ModalId, id)
    })

    $(document).on('click', "#company-edit-button", function() {
        let id = $(this).data("company-id");
        let url = "{{route('settings.company',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-company-mode-edit";
        let formId = "#company-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, id)
    })
    
    $(document).on('click', "#smtp-edit-button", function() {
        let id = $(this).data("smtp-id");
        let url = "{{route('settings.smtp',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-smtp-mode-edit";
        let formId = "#smtp-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, id)
    })

    $(document).on('click', "#aftership-edit-button", function() {
        let id = $(this).data("aftership-id");
        let url = "{{route('settings.aftership',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-aftership-mode-edit";
        let formId = "#aftership-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, id)
    })

    $("#nl-logo-edit-file").change(function () {
       
    filePreview(this);
});
    function filePreview(input) {
    if (input.files && input.files[0]) {  
        var reader = new FileReader();
        reader.onload = function (e) {  
        //   const parentDiv = input.closest('.nl-logo-file-edit-preview');
            // console.log( parentDiv )
            // input.sibling('.nl-logo-file-edit-preview').html('<div class="text-center p-3 img-round"><img class="nl-exship-file-add-preview" src="'+e.target.result+'" width="450" height="300"/></div>');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>


@endpush