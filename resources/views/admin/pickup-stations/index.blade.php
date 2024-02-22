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
        <h3 class="text-themecolor mb-0">Pickup Stations</h3>
        <!-- <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Address</li>
        </ol> -->
    </div>
    <!-- <div class="col-md-7 col-12 align-self-center d-none d-md-block">
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
    </div> -->
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
                            <h4 class="card-title mb-0">Pickup Stations</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{route('pickup-station.create')}}" class="btn btn-light-info text-info font-weight-medium waves-effect">Add</a>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row col-md-12">
                        <div class="col-md-4">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text fa fa-map-marker"></span>
                              </div>
                              <select class="form-control" name="branch_id" id="branch">
                                    <option value="">-- Select Branch --</option>
                                    @foreach($branches as $key => $name)
                                        <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="row station_data">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')

<script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script>

    $(document).on('click', "#branch", function() {
        let branch_id = $(this).val();
        let url = "{{route('pickup-station.branch-wise')}}";
        if(branch_id){
            var request = $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                data: {
                    branch_id:branch_id
                }
            });
            request.done(function(response) {
                if(response.length > 0){
                    $('.station_data').html('');
                    for (var i = 0; i<response.length; i++) {
                        let edit_it = "{{ route('pickup-station.edit', '') }}"+"/"+response[i].id;
                        let html = '<div class="col-md-6"><div class="card card-hover"><div class="card-header"><h4 class="mb-0 text-dark">'+response[i].name+'</h4></div><div class="card-body"><p class="card-text">'+response[i].address+'</p><a class="card-text">'+response[i].email+' </a><p class="card-text">('+response[i].country_code+') '+response[i].phone+'</p><div class="row"><div class="col-6 text-start"><a href="'+edit_it+'" style="font-size:20px"><i class="me-2 mdi mdi-table-edit"></i></a></div><div class="col-6 text-end"><a href="javascript:void(0)"  class="text-danger station-data-delete" href="#" data-station-id="'+response[i].id+'" style="font-size:20px"><i class="me-2 mdi mdi-delete"></i></a></div></div></div></div></div>';

                        $('.station_data').append(html);
                    }
                }
                else{
                      $('.station_data').html('No data available!');  
                }
            });
            request.fail(function(jqXHR, textStatus) { 
                
                if(jqXHR.status == '422'){
                         notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
               }
            });
        }
        
    })

    $(document).on('click', ".station-data-delete", function() {
        let id = $(this).data("station-id");
        let url = "{{route('pickup-station.destroy',['id' => ':id'])}}";
        url = url.replace(':id', id);
        deleteAjax(url)
    })
</script>
@endpush