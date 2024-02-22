@extends('user.layout.master')

@section('content')

<style>
    body.blur-effect {
  filter: blur(8px);
  pointer-events: none; /* Prevent interactions with blurred content */
}
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Dashboard</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
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
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <div class="card-group">
        <!-- Column -->
        <div class="card">
            <a href="{{route('user.parcel.index')}}" target="_blank">
                <div class="card-body text-center">
                    <h4 class="text-center">Total Parcels</h4>
                    <div class="d-flex justify-content-center mt-3">
                        <div id="total-parcels-count" style="width: 120px"></div>
                    </div>
                </div>
                <div class="p-2 rounded border-top text-center">
                    <h4 class="font-medium mb-0">
                        <!-- <i class="ti-angle-up text-success"></i> -->
                        {{count($data['parcels'])}}
                    </h4>
                </div>
            </a>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="card">
            <a href="{{route('user.purchasing.order.list')}}" target="_blank">
                <div class="card-body text-center">
                    <h4 class="text-center">Purchase Orders</h4>
                    <div class="d-flex justify-content-center mt-3">
                        <div id="total-orders" style="width: 120px"></div>
                    </div>
                </div>
                <div class="p-2 rounded border-top text-center">
                    <h4 class="font-medium mb-0">
                        <!-- <i class="ti-angle-down text-danger"></i> -->
                        {{count($data['orders'])}}
                    </h4>
                </div>
            </a>
        </div>
        <!-- Column -->
        <!-- Column -->

        <div class="card">
            <a href="{{route('user.consolidate.index')}}" target="_blank">
                <div class="card-body text-center">
                    <h4 class="text-center">Total Consolidates</h4>
                    <div class="d-flex justify-content-center mt-3">
                        <div id="total-consolidates" style="width: 120px"></div>
                    </div>
                </div>
                <div class="p-2 rounded border-top text-center">
                    <h4 class="font-medium mb-0">
                        <!-- <i class="ti-angle-down text-danger"></i> -->
                        {{count($data['consolidates'])}}
                    </h4>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card bg-orange text-white">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <!-- <a href="JavaScript: void(0);"><i class="display-6 cc BTC-alt text-white" title="BTC"></i></a> -->
                        <div class="ms-3 mt-2">
                            <h4 class="font-weight-medium mb-0 text-white">Current Balance</h4>
                            @if($user->balance() < 0) <h5 class="" style="color: #FF0000;">ƒ {{number_format($user->balance(),2)}} ANG</h5>
                                @else
                                <h5 class="text-white">ƒ {{number_format($user->balance(),2)}} ANG</h5>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <!-- <a href="JavaScript: void(0);"><i class="display-6 cc BTC-alt text-white" title="BTC"></i></a> -->
                        <div class="ms-3 mt-2">
                            <h4 class="font-weight-medium mb-0 text-white">Total Credited</h4>
                            <h5 class="text-white">ƒ {{number_format($user->credit(),2)}} ANG</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <!-- <a href="JavaScript: void(0);"><i class="display-6 cc BTC-alt text-white" title="BTC"></i></a> -->
                        <div class="ms-3 mt-2">
                            <h4 class="font-weight-medium mb-0 text-white">Total Debited</h4>
                            <h5 class="text-white">ƒ {{number_format($user->debit(),2)}} ANG</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->
    <!-- <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Visits</h4>
                            <div id="visitfromworld" style="width:100%!important; height:400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Browser Stats</h4>
                            <table class="table mt-3 table-borderless v-middle">
                                <tbody>
                                    <tr>
                                        <td class="ps-0" style="width:40px"><img
                                                src="../assets/images/browser/chrome-logo.png" alt=logo /></td>
                                        <td class="ps-0">Google Chrome</td>
                                        <td class="ps-0 text-end"><span
                                                class="badge bg-light-info text-info font-weight-medium">23%</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0"><img src="../assets/images/browser/firefox-logo.png" alt=logo />
                                        </td>
                                        <td class="ps-0">Mozila Firefox</td>
                                        <td class="ps-0 text-end">
                                            <span class="badge bg-light-danger text-danger font-weight-medium">15%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0"><img src="../assets/images/browser/safari-logo.png" alt=logo />
                                        </td>
                                        <td class="ps-0">Apple Safari</td>
                                        <td class="ps-0 text-end">
                                            <span class="badge bg-light-warning text-warning font-weight-medium">07%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0"><img src="../assets/images/browser/internet-logo.png" alt=logo />
                                        </td>
                                        <td class="ps-0">Internet Explorer</td>
                                        <td class="ps-0 text-end">
                                            <span class="badge bg-light-success text-success font-weight-medium">23%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0"><img src="../assets/images/browser/opera-logo.png" alt=logo />
                                        </td>
                                        <td class="ps-0">Opera mini</td>
                                        <td class="ps-0 text-end">
                                            <span class="badge bg-light-primary text-primary font-weight-medium">23%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0"><img src="../assets/images/browser/edge-logo.png" alt=logo />
                                        </td>
                                        <td class="ps-0">Microsoft edge</td>
                                        <td class="ps-0 text-end">
                                            <span class="badge bg-light-info text-info font-weight-medium">23%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0"><img src="../assets/images/browser/netscape-logo.png"
                                                alt=logo /></td>
                                        <td class="ps-0" class="text-truncate">Netscape Navigator</td>
                                        <td class="ps-0 text-end">
                                            <span class="badge bg-light-danger text-danger font-weight-medium">44%</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- shipping address row -->
          <!-- <div class="row">
                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <h4 class="card-title">Shipping Addresses</h4>
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zipcode</th>
                                </thead>
                                <tbody>
                                    @forelse($shippingAddresses as $shippingaddress)
                                        <tr>
                                            <td>{{ucwords($shippingaddress->first_name ?? 'N/A')}}</td>
                                            <td>{{ucwords($shippingaddress->last_name ?? 'N/A')}}</td>
                                            <td>{{$shippingaddress->phone ?? 'N/A'}}</td>
                                            <td>{{$shippingaddress->address ?? 'N/A'}}</td>
                                            <td>{{$shippingaddress->country->name ?? 'N/A'}}</td>
                                            <td>{{$shippingaddress->city ?? 'N/A'}}</td>
                                            <td>{{$shippingaddress->state ?? 'N/A'}}</td>
                                            <td>{{$shippingaddress->zipcode ?? 'N/A'}}</td>
                                        </tr>
                                        
                                    @empty
                                        <td colspan="8" class="text-center">No Data Available</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Row -->
          <div class="row">

            @foreach($data['branches'] as $branch)
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-header">
                        <h3>{{$branch->name ?? 'N/A'}} Branch Information</h3>
                    </div>
                    <div class="card-body">               
                            <div class="scrollable-content">
                                 <table class="table  table-responsive table-striped">
                                        <thead>
                                        
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td  style="width:30%;"><span class="fw-bold">First Name :</span></td>
                                            <td> <p class="card-text">{{$branch->name ?? 'N/A'}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold">Last Name :</span></td>
                                            <td> <p class="card-text">{{$branch->last_name ?? 'N/A'}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold">Address :</span></td>
                                            <td> <p class="card-text">{{$branch->address ?? 'N/A'}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold">Apt,Suite,Etc,(Optional) :</span></td>
                                         
                                            <td> <p class="card-text">{{$user->first_name ?? 'N/A'}} {{$user->last_name ?? 'N/A'}} / {{\Auth::guard('web')->user()->customer_no}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold">City :</span></td>
                                            <td> <p class="card-text">{{$branch->city ?? 'N/A'}}</p></td>
                                        </tr>
                                    
                                        <tr>
                                            <td><span class="fw-bold">State :</span></td>
                                        
                                            <td> <p class="card-text">{{$branch->state ?? 'N/A'}} </p></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold">Zip Code :</span></td>
                                            <td> <p class="card-text">{{$branch->zipcode ?? 'N/A'}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fw-bold">Phone :</span></td>
                                            <td> <p class="card-text">{{$branch->phone ?? 'N/A'}}</p></td>
                                        </tr>
                                        <!-- <tr>
                                            <td><span class="fw-bold">Address Line :</span></td>
                                            <td> <p class="card-text">{{$branch->address_line ?? 'N/A'}}</p></td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                             </div>


                        <!-- <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">First Name</h4><p>{{$branch->name ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title">Last Name</h4><p>{{$branch->last_name ?? 'N/A'}}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Phone</h4><p>{{$branch->phone ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title">ZipCode</h4><p>{{$branch->zipcode ?? 'N/A'}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                
                                <h4 class="card-title">State</h4><p>{{$branch->state ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title">City</h4><p>{{$branch->city ?? 'N/A'}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                
                                <h4 class="card-title">Street Address</h4><p>{{$branch->address ?? 'N/A'}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                
                                <h4 class="card-title">Address Line</h4><p>{{$branch->address_line ?? 'N/A'}}</p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            @endforeach
          </div>
            <!-- Row -->
            <div class="row">
        <!-- Column -->
        <div class="col-lg-8">
            <div class="card">
                <a href="{{route('user.parcel.index')}}" target="_blank">
                    <div class="card-body">
                        <div class="d-md-flex no-block align-items-center">
                            <h4 class="card-title">Total Parcels</h4>
                            <div class="ms-auto">
                                <ul class="list-inline">
                                    <li class="list-inline-item px-2">
                                        <h6 class="text-muted"><i class="fa fa-circle me-1 text-danger"></i>Unpaid
                                        </h6>
                                    </li>
                                    <li class="list-inline-item px-2">
                                        <h6 class="text-muted"><i class="fa fa-circle me-1 text-success"></i>Pending</h6>
                                    </li>
                                    <li class="list-inline-item px-2">
                                        <h6 class="text-muted"><i class="fa fa-circle me-1 text-info"></i>Paid
                                        </h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="total-parcel-graph"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-4">
            <div class="row">
                <div class="col-12">
                    <a href="{{route('user.wallet.index')}}" target="_blank">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Successful Wallet Transactions </h4>
                                <div class="row mt-4">
                                    <div class="col-sm-7 col-12">
                                        <span class="display-7 text-primary">ƒ {{number_format($data['approved_transactions'],2)}} ANG</span>
                                        <!--  <h6 class="text-muted">10% Increased</h6>
                                                <h5 class="text-nowrap">(150-165 Sales)</h5> -->
                                    </div>
                                    <div class="col-sm-5 col-12">
                                        <div class="float-sm-end mt-n5">
                                            <div id="sales-prediction"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <div class="card">
                        <a href="{{route('user.parcel.index')}}" target="_blank">
                            <div class="card-body">
                                <h4 class="card-title">Total Payment Recieved</h4>
                                <div class="row mt-4">
                                    <div class="col-sm-7 col-12">
                                        <span class="display-7 text-success">ƒ {{number_format($data['payment_recieved'],2) }} ANG</span>
                                        <!--   <h6 class="text-muted">10% Increased</h6>
                                                <h5 class="text-nowrap">(150-165 Sales)</h5> -->
                                    </div>
                                    <div class="col-sm-5 col-12">
                                        <div class="float-sm-end ms-5 ms-sm-0">
                                            <div id="sales-difference"></div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
            <!-- Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- BEGIN MODAL -->
                            <div class="modal" id="my-event">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title"><strong>Add Event</strong></h4>
                                            <button type="button" class="btn-close close-dialog" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary close-dialog waves-effect"
                                                data-bs-dismiss="modal" aria-label="Close">Close</button>
                                            <button type="button"
                                                class="btn btn-success save-event waves-effect waves-light">Create
                                                event</button>
                                            <button type="button"
                                                class="btn btn-danger delete-event waves-effect waves-light"
                                                data-bs-dismiss="modal">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-backdrop bckdrop hide"></div>
                            <!-- Modal Add Category -->
                            <div class="modal none-border" id="add-new-event">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title"><strong>Add</strong> a category</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Category Name</label>
                                                        <input class="form-control form-white" placeholder="Enter name"
                                                            type="text" name="category-name" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Choose Category Color</label>
                                                        <select class="form-select form-white"
                                                            data-placeholder="Choose a color..." name="category-color">
                                                            <option value="success">Success</option>
                                                            <option value="danger">Danger</option>
                                                            <option value="info">Info</option>
                                                            <option value="primary">Primary</option>
                                                            <option value="warning">Warning</option>
                                                            <option value="inverse">Inverse</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                class="btn btn-danger waves-effect waves-light save-category"
                                                data-bs-dismiss="modal">Save</button>
                                            <button type="button" class="btn btn-secondary waves-effect"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END MODAL -->
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div id="total-parcel-graph"></div>
                </div>
            </div>
            <!-- Row -->
            <!-- shipping address row -->
            <div class="row">
                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <h4 class="card-title">Recent Parcels</h4>
                            <div class="table table-responsive">  
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <th>Invoice #</th>
                                    <th>Reciever</th>
                                    <th>Destination</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Parcel Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @forelse($data['latest_parcels'] as $key => $parcel)
                                        <tr>
                                            <td>{{$parcel->invoice_no ?? 'N/A'}}</td>
                                            <td>{{$parcel->full_name ?? 'N/A'}}</td>
                                            <td>{{$parcel->sender->address ?? 'N/A'}}</td>
                                            <td>ƒ {{number_format($total[$key],2)}} ANG</td>
                                            <td>{{$parcel->paymentStatus->name}}<img class="ni-payment-show-modal" data-parcel-id="{{$parcel->id}}" src="{{asset('assets/icons')}}/{{$parcel->payment->icon}}" width="30px" /></td>
                                            <td>{{$parcel->parcelStatus->name}}</td>
                                            <td><a class="btn btn-sm" target="_blank" href="{{route('user.parcel.show',[$parcel->id])}}"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                        
                                    @empty
                                        <td colspan="7" class="text-center">No Data Available</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
            <!-- Row -->
            <div class="row">
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <h4 class="card-title">Recent Transactions</h4>
                             <div class="table table-responsive">
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <th>User</th>
                                    <th>Transaction Type</th>
                                    <!-- <th>Payment Method</th> -->
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @forelse($data['latest_wallets'] as $wallet)
                                        <tr>
                                            <td>{{$wallet->morphable->first_name}} {{$wallet->morphable->last_name}}</td>
                                            <td>{{ucwords($wallet->type)}}</td>
                                            <!-- <td>{{$wallet->payment->name}}</td> -->
                                            <td>{{$wallet->currency->symbol ?? ''}} {{number_format($wallet->amount,2) }}</td>
                                            <td><a class="btn btn-sm" target="_blank" href="{{route('wallet.index')}}"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                        
                                    @empty
                                        <td colspan="4" class="text-center">No Data Available</td>
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <h4 class="card-title">Recent Pending Purchase</h4>
                            <div class="table table-responsive">
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <th>Order #</th>
                                    <th>Reciever</th>
                                    <th>Distination City</th>
                                    <th>Order Status</th>
                                    <th>Total Amount</th>
                                </thead>
                                <tbody>
                                    @forelse($data['latest_orders'] as $order)
                                        <tr>
                                            
                                            <td><a href="{{route('purchasing.order.list')}}" target="_blank">{{$order->code}}</a></td>
                                            <td>{{$order->shipperAddress->first_name}} - {{$order->shipperAddress->last_name}}</td>
                                            <td>{{$order->shipperAddress->city}} </td>
                                            <td>{{$order->deliveryStatus->name}}</td>
                                            <td>{{$order->currency->symbol}} {{number_format($order->total,2)}}</td>
                                        </tr>
                                        
                                    @empty
                                        <td colspan="4" class="text-center">No Data Available</td>
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        <!-- </div> -->
    <!-- </div> -->
    <!-- Row -->
   <!--  <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal" id="my-event">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title"><strong>Add Event</strong></h4>
                                    <button type="button" class="btn-close close-dialog" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-dialog waves-effect" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    <button type="button" class="btn btn-success save-event waves-effect waves-light">Create
                                        event</button>
                                    <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-bs-dismiss="modal">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-backdrop bckdrop hide"></div>
                    <div class="modal none-border" id="add-new-event">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title"><strong>Add</strong> a category</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Category Name</label>
                                                <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Choose Category Color</label>
                                                <select class="form-select form-white" data-placeholder="Choose a color..." name="category-color">
                                                    <option value="success">Success</option>
                                                    <option value="danger">Danger</option>
                                                    <option value="info">Info</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="warning">Warning</option>
                                                    <option value="inverse">Inverse</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-bs-dismiss="modal">Save</button>
                                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Row -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer">
    All Rights Reserved by Noah Imports.
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->


<!-- Add modal content -->
<div class="modal fade" id="ni-rec-add-first" tabindex="-1" aria-labelledby="ni-rec-add-first" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center" style="background-color: #26c6da;">
                <h4 class="modal-title text-white" id="myLargeModalLabel">My Personal Information</h4> 
            </div>
            <div class="modal-body" id="ni-rec-add-first-body">

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
<script src="{{asset('js/pages/dashboards/dashboard4.js')}}"></script>
<script>
    // Graph for total parcels count month wise
    var paidCount = @json($parcelCountresult['paid_count']);
    var unpaidCount = @json($parcelCountresult['unpaid_count']);
    var pendingCount = @json($parcelCountresult['pending_count']);
    var totalParcels = @json($totalParcelsArray);
    var totalOrders = @json($totalOrdersArray);
    var totalConsolidates = @json($totalConsolidatesArray);

    var options_total_revenue = {
        series: [{
            name: 'Unpaid ',
            data: [unpaidCount[1], unpaidCount[2], unpaidCount[3], unpaidCount[4], unpaidCount[5], unpaidCount[6], unpaidCount[7], unpaidCount[8], unpaidCount[9], unpaidCount[10], unpaidCount[11], unpaidCount[12]]
        }, {
            name: 'Pending ',
            data: [pendingCount[1], pendingCount[2], pendingCount[3], pendingCount[4], pendingCount[5], pendingCount[6], pendingCount[7], pendingCount[8], pendingCount[9], pendingCount[10], pendingCount[11], pendingCount[12]]
        }, {
            name: 'Paid ',
            data: [paidCount[1], paidCount[2], paidCount[3], paidCount[4], paidCount[5], paidCount[6], paidCount[7], paidCount[8], paidCount[9], paidCount[10], paidCount[11], paidCount[12]]
        }],
        chart: {
            fontFamily: 'Poppins,sans-serif',
            type: 'bar',
            height: 300,
            stacked: true,
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: true
            }
        },
        grid: {
            borderColor: 'rgba(0,0,0,0.1)',
            strokeDashArray: 3,
        },
        colors: ['#FC4B6C', '#21C1D6', '#1E88E5'],
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '15%',
            },
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            theme: "dark",
        },
        legend: {
            show: false
        },
        fill: {
            opacity: 1
        }
    };

    var chart_column_stacked = new ApexCharts(document.querySelector("#total-parcel-graph"), options_total_revenue);
    chart_column_stacked.render();

    // Graph for dashboard parcels count month wise

    var option_unique_visit = {
        series: [{
            name: '',
            data: [totalParcels[0], totalParcels[1], totalParcels[2], totalParcels[3], totalParcels[4], totalParcels[5], totalParcels[6], totalParcels[7], totalParcels[8], totalParcels[9], totalParcels[10], totalParcels[11]]
        }],
        chart: {
            type: 'bar',
            height: 70,
            toolbar: {
                show: false,
            },
            sparkline: {
                enabled: true
            },
        },
        colors: ["#26c6da"],
        grid: {
            show: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                startingShape: 'flat',
                endingShape: 'flat',
                columnWidth: '95%',
                barHeight: '100%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 4,
            colors: ['transparent']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        axisBorder: {
            show: false,
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
            style: {
                fontSize: '12px',
                fontFamily: 'Poppins,sans-serif',
            },
            x: {
                show: false,
            },
            y: {
                formatter: undefined,
            }
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#total-parcels-count"), option_unique_visit);
    chart_column_basic.render();


    var option_total_visit = {
        series: [{
            name: '',
            data: [totalOrders[0], totalOrders[1], totalOrders[2], totalOrders[3], totalOrders[4], totalOrders[5], totalOrders[6], totalOrders[7], totalOrders[8], totalOrders[9], totalOrders[10], totalOrders[11]]
        }],
        chart: {
            fontFamily: 'Poppins,sans-serif',
            type: 'bar',
            height: 70,
            toolbar: {
                show: false,
            },
            sparkline: {
                enabled: true
            },
        },
        colors: ["#7460ee"],
        grid: {
            show: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                startingShape: 'flat',
                endingShape: 'flat',
                columnWidth: '95%',
                barHeight: '100%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 4,
            colors: ['transparent']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        axisBorder: {
            show: false,
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
            style: {
                fontSize: '12px',
                fontFamily: 'Poppins,sans-serif',
            },
            x: {
                show: false,
            },
            y: {
                formatter: undefined,
            }
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#total-orders"), option_total_visit);
    chart_column_basic.render();


    var option_bounce_rate = {
        series: [{
            name: '',
            data: [totalConsolidates[0], totalConsolidates[1], totalConsolidates[2], totalConsolidates[3], totalConsolidates[4], totalConsolidates[5], totalConsolidates[6], totalConsolidates[7], totalConsolidates[8], totalConsolidates[9], totalConsolidates[10], totalConsolidates[11]]
        }],
        chart: {
            type: 'bar',
            height: 70,
            toolbar: {
                show: false,
            },
            sparkline: {
                enabled: true
            },
        },
        colors: ["#03a9f3"],
        grid: {
            show: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                startingShape: 'flat',
                endingShape: 'flat',
                columnWidth: '95%',
                barHeight: '100%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 4,
            colors: ['transparent']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        axisBorder: {
            show: false,
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
            style: {
                fontSize: '12px',
                fontFamily: 'Poppins,sans-serif',
            },
            x: {
                show: false,
            },
            y: {
                formatter: undefined,
            }
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#total-consolidates"), option_bounce_rate);
    chart_column_basic.render();


    ! function($) {
        "use strict";

        var eventMyObj = '';
        var CalendarApp = function() {
            this.$body = $("body")
            this.$calendar = $('#calendar'),
                eventMyObj = this.$event = ('#calendar-events div.calendar-events'),
                this.$categoryForm = $('#add-new-event form'),
                this.$extEvents = $('#calendar-events'),
                this.$modal = $('#my-event'),
                this.$saveCategoryBtn = $('.save-category'),
                this.$calendarObj = null
        };


        /* on drop */
        CalendarApp.prototype.onDrop = function(eventObj, date) {


            },
            /* on click on event */
            CalendarApp.prototype.onEventClick = function(calEvent, jsEvent, view) {
                let url = "";
                var $this = this;
                if(calEvent.type == 'parcel'){
                    url = "{{route('user.parcel.show',['id' => ':id'])}}";
                } 
                if(calEvent.type == 'order'){
                     url = "{{route('user.purchasing.order.show',['id' => ':id'])}}";
                } 
                if(calEvent.type == 'consolidate'){
                     url = "{{route('user.consolidate.show',['id' => ':id'])}}";
                } 
                var id = calEvent.id.split("-"); 
                url = url.replace(':id', id[1]);
                window.open(url, "_blank");
            },
            /* on select */
            CalendarApp.prototype.onSelect = function(start, end, allDay) {

                var $this = this;


            },
            CalendarApp.prototype.enableDrag = function() {

                //init events
                $(this.$event).each(function() {
                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    };
                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);
                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 999,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    });
                });
            };
        $(document).on("mouseenter", ".fc-event-container", function() {
            $(this).draggable({
                // Event handler for when dragging starts
                start: function(calEvent, jsEvent, view) {
                    console.log("Dragging started");
                    // Perform any desired action here
                },

                // Event handler for when dragging stops
                stop: function(calEvent, jsEvent, view) {
                    console.log(calEvent);
                    // Perform any desired action here
                }
            });
        });




        /* Initializing */
        CalendarApp.prototype.init = function() {
                this.enableDrag();
                /*  Initialize the calendar  */
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var form = '';
                var today = new Date($.now());

                var events = [
                    @foreach($data['parcels'] as $val) {
                        title: "{{date('d-M', strtotime($val->es_delivery_date))}}",
                        start: "{{$val->es_delivery_date}}",
                        className: 'bg-info',
                        id: 'p-{{$val->id}}',
                        type: 'parcel',
                    },
                    @endforeach
                    @foreach($data['orders'] as $val) {
                        title: "{{$val->created_at->format('d M')}}",
                        start: "{{$val->created_at}}",
                        className: 'bg-primary',
                        id: 'o-{{$val->id}}',
                        type: 'order',
                    },
                    @endforeach
                    @foreach($data['consolidates'] as $val) {
                        title: "{{date('d-M', strtotime($val->es_delivery_date))}}",
                        start: "{{$val->es_delivery_date}}",
                        className: 'bg-success',
                        id: 'c-{{$val->id}}',
                        type: 'consolidate',
                    },
                    @endforeach
                ];

                var $this = this;
                $this.$calendarObj = $this.$calendar.fullCalendar({
                    slotDuration: '00:15:00',
                    /* If we want to split day time each 15minutes */
                    minTime: '08:00:00',
                    maxTime: '19:00:00',
                    defaultView: 'month',
                    handleWindowResize: true,

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: events,
                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    eventLimit: true, // allow "more" link when too many events
                    selectable: true,
                    drop: function(date) {
                        $this.onDrop($(this), date);
                    },
                    eventDrop: function(event, delta, revertFunc) {
                        // Get the dropped event's date
                        var droppedDate = event.start.format("MM/DD/YYYY");
                        var eventType = event.type;
                        var id = event.id;
                        if(eventType == 'parcel'){
                            $.ajax({
                                url: "{{route('user.parcel.deliveryDate.update')}}",
                                method: "PUT",
                                headers: {
                                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                                },
                                data: {
                                    id : id,
                                    droppedDate : droppedDate,
                                    eventType : eventType,
                                },
                            })
                            // Ajaxt on Done Section here
                            .done(function(response) {

                                if (response.success) {
                                    notify('success', response.success);
                                }

                            });
                        }
                        if(eventType == 'consolidate'){
                            $.ajax({
                                url: "{{route('user.consolidate.deliveryDate.update')}}",
                                method: "PUT",
                                headers: {
                                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                                },
                                data: {
                                    id : id,
                                    droppedDate : droppedDate,
                                    eventType : eventType,
                                },
                            })
                            // Ajaxt on Done Section here
                            .done(function(response) {

                                if (response.success) {
                                    notify('success', response.success);
                                }

                            });
                        }
                    },
                    select: function(start, end, allDay) {
                        $this.onSelect(start, end, allDay);
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        $this.onEventClick(calEvent, jsEvent, view);
                    }

                });

                //on new event
                this.$saveCategoryBtn.on('click', function() {
                    var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                    var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                    if (categoryName !== null && categoryName.length != 0) {
                        $this.$extEvents.append('<div class="calendar-events mb-3" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-circle text-' + categoryColor + ' me-2" ></i>' + categoryName + '</div>')
                        $this.enableDrag();
                    }

                });
            },

            //init CalendarApp
            $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

    }(window.jQuery),

    //initializing CalendarApp
    $(window).on('load', function() {

        $.CalendarApp.init()


    });
    
    @if(Auth::guard('web')->user()->alert == 0)
    $(document).ready(function() { 
    //  document.body.classList.add('blur-effect'); 
    let url = "{{route('user.checkShipper')}}";
    $('#ni-rec-add-first').modal({
    backdrop: 'static',
    keyboard: false // Prevent closing the modal with the keyboard ESC key
  });
    getHtmlAjax(url, "#ni-rec-add-first", "#ni-rec-add-first-body")
    // document.body.classList.remove('blur-effect');
    });
    @endif
  
    // Action On Click Reciever Address Form Add Button
    $(document).on('click', "#ni-reciever-address-add-btn", function() { 
        forms = $("#ni-reciever-address-add-form")[0];
        block("body");
        var form = new FormData(forms);
        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('user.parcel.addreciever')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }, 
            processData: false,
            contentType: false,
            data: form,
        }); 
        request.done(function(response) {
            unblock("body")
            if (response.success) {
                notify('success', response.success);
                 // Hiding Current modal
            $("#ni-rec-add-first").modal('hide');
            // Empty the current modal
            $('.modal-body').html('');
            }  
            // Appending values to Reciever address Select data
            if (response.value) {
                
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            $(document).ready(function() { 
            if (jqXHR.status == '422') {
                notify('error', "The Given Data Is Invalid");
                $('.invalid-feedback').remove()
                $(":input").removeClass('is-invalid')
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function(index, value) {
                    if ($("input[name=" + index + "]").length) {
                        $("input[name=" + index + "]").addClass('is-invalid');
                        $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }


                    if ($("select[name=" + index + "]").length) {
                        $("select[name=" + index + "]").addClass('is-invalid');
                        $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                    if ($("textarea[name=" + index + "]").length) {
                        $("textarea[name=" + index + "]").addClass('is-invalid');
                        $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                });
            }
        });
        });

    });
</script>
@endpush