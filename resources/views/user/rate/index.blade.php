@extends('user.layout.master')

@section('content') 
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Branch Rates</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Rate</li>
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
                            <h4 class="card-title mb-0">Branch Rates</h4>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                        <div class="col-6">
                            <select class="form-control" id="branch_id">
                                @foreach($branch as $bran)
                                <option value="{{$bran->id}}">{{$bran->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <h5 class="card-subtitle mb-3">Swipe Mode, ModeSwitch, Minimap, Sortable, SortableSwitch</h5> -->
                    <table class="tablesaw table-bordered table-hover table no-wrap data-table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                        <thead>
                            <tr>
                                <!--<th class="border"> No#</th>-->
                                <th class="border">LB</th>
                                <th class="border">Amount</th>
                                <!--<th class="border">Created At</th>-->
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

@endsection

@push('footer-script') 
<script>
          var table
          loadtable();

    function loadtable(params = null) {
        var branch = $('#branch_id').val(); 
        if (branch == '') {
            branch = null;
        }
        table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: "{{route('user.rate.data')}}?branch="+branch,
            columns: [
                {
                    data: 'kg',
                    name: 'kg'
                },
                {
                    data: 'amount',
                    name: 'amount'
                }, 
                // {
                //     data: 'created_at',
                //     name: 'created_at'
                // },
            ]
        });
    }
    $('#branch_id').change(function () {
        loadtable();
    });
 

</script>
@endpush