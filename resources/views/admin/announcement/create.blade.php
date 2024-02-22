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
        <h3 class="text-themecolor mb-0">Announcement</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Create</a></li>
            <li class="breadcrumb-item active">Announcement</li>
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
            <div class="card col-md-12">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Make announcement to all users</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="post" action="{{route('announcement.store')}}">
                        @csrf
                        <label for="tb-remail">From Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-envelope"></span>
                            <input class="form-control" type="email" name="email" value="{{$settings->smtp->email}}" readonly />
                        </div>
                        @error('email')
                            <div class="text text-danger mb-3">{{ $message }}</div>
                        @enderror
                        <label for="tb-remail">Subject</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-envelope"></span>
                            <input id="subject" class="form-control" type="text" name="subject" />
                        </div>
                        @error('subject')
                            <div class="text text-danger mb-3">{{ $message }}</div>
                        @enderror

                        <label for="tb-remail">Message</label>
                        <div class="form-group-group mb-3">
                            <textarea cols="80" id="message" name="message" rows="10">
                            </textarea>
                        </div>
                        @error('message')
                            <div class="text text-danger mb-3">{{ $message }}</div>
                        @enderror
                        
                        <div class="d-flex align-items-stretch">
                            <button type="submit" class="btn btn-success">Send</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')

<script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script>
    CKEDITOR.replace('message', {
        height: 150
    });
</script>
@endpush