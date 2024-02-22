@extends('admin.layout.master')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/dropzone/dist/min/dropzone.min.css')}}">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Profile & Privacy</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Account</a></li>
            <li class="breadcrumb-item active">Profile & Privacy</li>
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
                            <h4 class="card-title mb-0">Profile & Privacy</h4>
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
                            <a class="nav-link d-flex active" data-bs-toggle="tab" href="#privacy" role="tab">
                                <span><i class="ti-home"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Privacy</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#change_password" role="tab">
                                <span><i class="ti-user"></i>
                                </span>
                                <span class="d-none d-md-block ms-2">Change Password</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane p-3 active" id="privacy" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="privacy-edit-form" action="javascript:void(0)" enctype="multipart/form-data">
                                    <input type="hidden" name="formType" value="privacy"> 
                                    <div class="mb-3 row">
                                        <label for="image" class="col-sm-3 text-start control-label col-form-label">Profile Photo</label>
                                        <div class="col-sm-3">
                                            @if(isset($user->image))
                                                <div class="text-center p-3 img-round"><img class="nl-exship-file-edit-preview" src="{{asset('storage/assets/admin-profile')}}/{{$user->image}}" width="100" height="100"/></div>
                                            @endif
                                            <div class="col-12" id="ni-user-file-append">

                                            </div> 
                                        </div>
                                         <div class="col-sm-6">  
                                         <input type="file" id="image" class="form-control" name="image" placeholder="Upload logo">
                                         </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">Theme</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="theme" style="width: 100%">
                                                <option value="">Select Theme</option>
                                                <option value="1" {{$user->theme == 1 ? 'selected' : ''}}>Sunny</option>
                                                <option value="2" {{$user->theme == 2 ? 'selected' : ''}}>Night Owl</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">TimeZone</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="timezone_id" style="width: 100%">
                                                <option value="">-- Select Timezone --</option>
                                                @foreach($timezones as $key => $val)
                                                    <option value="{{$key}}" {{$user->timezone_id == $key ? 'selected' : ''}}>{{$val}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">Language</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="lang" style="width: 100%">
                                                <option value="">-- Select Language --</option>
                                                <option value="english" {{$user->lang == 'english' ? 'selected' : ''}}>English</option>
                                                <option value="arabic" {{$user->lang == 'arabic' ? 'selected' : ''}}>Arabic</option>
                                                <option value="spanish" {{$user->lang == 'spanish' ? 'selected' : ''}}>Apanish</option>
                                                <option value="dutch" {{$user->lang == 'dutch' ? 'selected' : ''}}>Dutch</option>
                                                <option value="chinese" {{$user->lang == 'chinese' ? 'selected' : ''}}>Chinese</option> 
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="user-edit-button" data-user-id="{{$user->id}}">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="change_password" role="tabpanel">
                            <div class="p-3 text-start">
                                <form class="form-horizontal" id="password-edit-form" action="javascript:void(0)">
                                    <input type="hidden" name="formType" value="change-password">
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">New Password :</label>
                                        <div class="col-sm-9">
                                            <input id="password" class="form-control" type="password" name="password" autocomplete="new-password" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="fname" class="col-sm-3 text-start control-label col-form-label">Confirm Password:</label>
                                        <div class="col-sm-9">
                                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" />
                                            <div class="invalid-feedback">
                                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="password-edit-button" data-user-id="{{$user->id}}">Save</button>
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
    $( document ).ready(function() {
       $('.select2').select2();
    });

    $(document).on('click', "#user-edit-button", function() {
        let id = $(this).data("user-id");
        let url = "{{route('account.privacy.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-privacy-mode-edit";
        let formId = "#privacy-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, id)
    })

    $(document).on('click', "#password-edit-button", function() {
        let id = $(this).data("user-id");
        let url = "{{route('account.password.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let ModalId = "#ni-password-mode-edit";
        let formId = "#password-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, id)
    })
    

    $("#image").change(function() {
        filePreview(this);
    });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.nl-exship-file-edit-preview').remove();
                if (input.files[0].type.indexOf('image') === 0) {
                  // If it's an image, display it in the file preview
                  $('#ni-user-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
                } else {
                  // If it's not an image, display the document icon
                  $('#ni-user-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


@endpush