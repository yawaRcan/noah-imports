<style type="text/css">
    body {
        margin-top: 20px;
    }

    .steps .step {
        display: block;
        width: 100%;
        margin-bottom: 35px;
        text-align: center
    }

    .steps .step .step-icon-wrap {
        display: block;
        position: relative;
        width: 100%;
        height: 80px;
        text-align: center
    }

    .steps .step .step-icon-wrap::before,
    .steps .step .step-icon-wrap::after {
        display: block;
        position: absolute;
        top: 50%;
        width: 50%;
        height: 3px;
        margin-top: -1px;
        background-color: #e1e7ec;
        content: '';
        z-index: 1
    }

    .steps .step .step-icon-wrap::before {
        left: 0
    }

    .steps .step .step-icon-wrap::after {
        right: 0
    }

    .steps .step .step-icon {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        border: 1px solid #e1e7ec;
        border-radius: 50%;
        background-color: #f5f5f5;
        color: #374250;
        font-size: 38px;
        line-height: 81px;
        z-index: 5
    }

    .steps .step .step-title {
        margin-top: 16px;
        margin-bottom: 0;
        color: #606975;
        font-size: 14px;
        font-weight: 500
    }

    .steps .step:first-child .step-icon-wrap::before {
        display: none
    }

    .steps .step:last-child .step-icon-wrap::after {
        display: none
    }

    .steps .step.completed .step-icon-wrap::before,
    .steps .step.completed .step-icon-wrap::after {
        background-color: #0da9ef
    }

    .steps .step.completed .step-icon {
        border-color: #0da9ef;
        background-color: #0da9ef;
        color: #fff
    }

    @media (max-width: 576px) {

        .flex-sm-nowrap .step .step-icon-wrap::before,
        .flex-sm-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 768px) {

        .flex-md-nowrap .step .step-icon-wrap::before,
        .flex-md-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 991px) {

        .flex-lg-nowrap .step .step-icon-wrap::before,
        .flex-lg-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    @media (max-width: 1200px) {

        .flex-xl-nowrap .step .step-icon-wrap::before,
        .flex-xl-nowrap .step .step-icon-wrap::after {
            display: none
        }
    }

    .bg-faded,
    .bg-secondary {
        background-color: #f5f5f5 !important;
    }
</style>

<div class="container padding-bottom-3x mb-1">
    <div class="card mb-3">
        <div class="p-4 text-center text-white text-lg rounded-top" style="background-color: #26C6DA;"><span class="text-uppercase">Tracking No - </span><span class="text-medium">{{$parcel->external_tracking ?? 'N/A'}}</span></div>
        <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped Via:</span> {{$parcel->externalShipper->name ?? 'N/A'}}</div>
            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Status:</span> {{$parcel->parcelStatus->name ?? 'N/A'}}</div>
            <div class="w-100 text-center py-1 px-2"><span class="text-medium">Delivery Date:</span> {{date('d-M-y', strtotime($parcel->es_delivery_date))}}</div>
        </div>
        <div class="card-body">
            <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                @foreach($statuses as $status)
                @php
                if($parcel->parcelStatus->slug == 'at-warehouse-miami')
                    $parcelStatusId = 1;
                else
                    $parcelStatusId = $parcel->parcelStatus->id;
                @endphp
                <div class="step {{$parcelStatusId >= $status->id ? 'completed' : ''}}">
                    <div class="step-icon-wrap">
                        <div class="step-icon">
                            @if($status->slug == 'pending')
                            <i class="fas fa-clock"></i>
                            @elseif($status->slug == 'processing')
                            <i class="fas fa-box-open"></i>
                            @elseif($status->slug == 'in-transit')
                            <i class="fas fa-shipping-fast"></i>
                            @elseif($status->slug == 'in-transit-to-be-delivered')
                            <i class="fas fa-warehouse"></i>
                            @elseif($status->slug == 'delivered')
                            <i class="fas fa-home"></i>
                            @else
                            <i class="fas fa-home"></i>
                            @endif
                        </div>
                    </div>
                    <h4 class="step-title">{{ucwords($status->name)}}</h4>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @if(!is_null($onlineTracking))
    <div class="d-flex flex-wrap flex-md-nowrap justify-content-center justify-content-sm-between align-items-center">
        <div class="text-left text-sm-right"><a class="btn btn-outline-primary btn-rounded btn-sm" href="javascript:void(0)" data-parcel-id="{{$parcel->id}}" id="ni-get-online-tracking">View Online Tracking</a></div>
    </div>
    <div id="ni-online-tracking-data" class="hide mt-3">
        <div class="card mb-3">
            <div class="p-4 text-center text-white text-lg rounded-top" style="background-color: #26C6DA;"><span class="text-uppercase">Online Tracking No - </span><span class="text-medium">{{$parcel->external_tracking ?? 'N/A'}}</span></div>
            <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
                <div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped Via:</span> <br> {{$onlineTracking['data']['shipment_type'] ?? 'N/A'}}</div>
                <div class="w-100 text-center py-1 px-2"><span class="text-medium">Current Status:</span><br> {{$onlineTracking['data']['tag'] ?? 'N/A'}}</div>
                <div class="w-100 text-center py-1 px-2"><span class="text-medium">Delivery Date:</span> <br>{{date('d-M-y', strtotime($onlineTracking['full_data']['expected_delivery'] ?? 'N/A'))}}</div>
                <div class="w-100 text-center py-1 px-2"><span class="text-medium">Current Location:</span> <br>{{$onlineTracking['data']['checkpoints'][$lastIndex]['location'] ?? 'N/A'}}</div>
            </div>
            <div class="card-body">
                <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                    @foreach($onlineStatuses as $status)
                    <div class="step {{$status['value'] <= $statusValue ? 'completed' : ''}}">
                        <div class="step-icon-wrap">
                            <div class="step-icon">
                                @if($status['status'] == 'Pending')
                                <i class="fas fa-clock"></i>
                                @elseif($status['status'] == 'InfoReceived')
                                <i class="fas fa-box-open"></i>
                                @elseif($status['status'] == 'InTransit')
                                <i class="fas fa-shipping-fast"></i>
                                @elseif($status['status'] == 'OutForDelivery')
                                <i class="fas fa-warehouse"></i>
                                @elseif($status['status'] == 'Delivered')
                                <i class="fas fa-home"></i>
                                @endif
                            </div>
                        </div>
                        @if($status['status'] == 'InfoReceived')
                        <h4 class="step-title">{{ucwords('Processing')}}</h4>
                        @elseif($status['status'] == 'OutForDelivery')
                        <h4 class="step-title">{{ucwords('In Transit To Be Delivered')}}</h4>
                        @else
                        <h4 class="step-title">{{ucwords($status['status'])}}</h4>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    $('#ni-get-online-tracking').click(function(e) {

        $("#ni-online-tracking-data").slideToggle();
    })
</script>