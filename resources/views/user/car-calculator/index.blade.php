@extends('user.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Car Calculator</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">More</a></li>
            <li class="breadcrumb-item active">Car Calculator</li>
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
                            <h4 class="card-title mb-0">Car Calculator</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <label>Car Make</label>
                            <select id="ni-car-make" class="select2 form-control custom-select" style="width: 90%;">
                                <option value="">Select Make</option>
                                @foreach($makes as $make)
                                    <option value="{{$make}}">{{$make}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Car Model</label>
                            <select id="ni-car-model" class="select2 form-control custom-select" style="width: 90%;">
                                <option value="">Select Make First</option>
                            </select>
                        </div>
                    </div>

                    <div class="row col-md-12 mt-4">
                        <div class="col-md-6">
                            <label>Car Price ($)</label>
                            <input type="number" id="car-price" class="form-control" placeholder="Enter car price">
                        </div>
                        <div class="col-md-6">
                            <label>Car Agency buyer fees ($)</label>
                            <input type="number" value="450.00" id="car-agency-fee" readonly class="form-control">
                        </div>
                    </div>

                    <div class="row col-md-12 mt-4">
                        <div class="col-md-6">
                            <label>Shipping charges USA-USA ($)</label>
                            <input type="number" value="800.00" id="shipping-charges-usa" readonly class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Shipping charges USA-Gomez shipping Curacao ($)</label>
                            <input type="number" value="1825.00" id="shipping-charges-usa-gomez" readonly class="form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="row col-md-12 mt-4">
                        <div class="col-md-4">
                            <p><b>Subtotal</b></p>
                        </div>
                        <div class="col-md-4">
                            <p>$<span class="dollar-subtotal">0</span></p>
                        </div>
                        <div class="col-md-4">
                            <p>ƒ <span class="ang-subtotal">0</span> ANG</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row col-md-12 mt-4">
                        <div class="col-md-4">
                            <label>Vehicle Type</label>
                            <select class="form-control" id="vehicle-type">
                                <option value="">Select Vehicle Type</option>
                                <option value="gas">Gas Vehicle</option>
                                <option value="electric">Electric vehicle</option>
                            </select>
                        </div>
                    </div>

                    <div class="row col-md-12 mt-4">
                        <div class="col-md-4">
                            <p><b>Invoer rechten (<span class="tax-percentage">0</span>%)</b></p>
                        </div>
                        <div class="col-md-4">
                            <p>$<span class="dollar-tax">0</span></p>
                        </div>
                        <div class="col-md-4">
                            <p>ƒ <span class="ang-tax">0</span> ANG</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row col-md-12 mt-4">
                        <div class="col-md-4">
                            <p><b>Total in Guldens</b></p>
                        </div>
                        <div class="col-md-4">
                            <p>$<span class="dollar-total">0</span></p>
                        </div>
                        <div class="col-md-4">
                            <p>ƒ <span class="ang-total">0</span> ANG</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')
 <script>
    $( document ).ready(function() {

     $('.select2').select2();
     var currency_val = "{{$currencyVal}}"
     $('#car-price').blur(function(){

        let price = $(this).val();
        if(price){
            let agency_fee = $('#car-agency-fee').val();
            let usa_charges = $('#shipping-charges-usa').val();
            let usa_gomez_charges = $('#shipping-charges-usa-gomez').val();
            let subtotal = parseFloat(price) + parseFloat(agency_fee) + parseFloat(usa_charges) + parseFloat(usa_gomez_charges);
            subtotal = subtotal.toFixed(2);

            let ang_total = subtotal * currency_val;
            ang_total = ang_total.toFixed(2);
            $('.dollar-subtotal').text(subtotal);
            $('.ang-subtotal').text(ang_total);
        }

     });

     $('#vehicle-type').change(function(){

        let type = $(this).val();
        let car_price = $('#car-price').val();
        if(!car_price){
            alert('please enter car price');
            $(this).val('');
            $('#car-price').focus();
            return;
        }
        if(type && car_price){
            let percentage = 0;
            if(type == 'gas'){
                percentage = 36;
            }else if(type == 'electric'){
                percentage = 9;
            }

            let dollar_tax = $('.dollar-subtotal').text() * (percentage/100);  
            let ang_tax = $('.ang-subtotal').text() * (percentage/100);
            dollar_tax = dollar_tax.toFixed(2);
            ang_tax = ang_tax.toFixed(2);

            let dollar_total = parseFloat($('.dollar-subtotal').text()) + parseFloat(dollar_tax);
            let ang_total = parseFloat($('.ang-subtotal').text()) + parseFloat(ang_tax);
            dollar_total = dollar_total.toFixed(2);
            ang_total = ang_total.toFixed(2);

            $('.tax-percentage').text(percentage);
            $('.dollar-tax').text(dollar_tax);
            $('.ang-tax').text(ang_tax);
            $('.dollar-total').text(dollar_total);
            $('.ang-total').text(ang_total);
        }

     });

     $(document).on('change', "#ni-car-make", function(e) {
        e.preventDefault();

        var make = $(this).val();

        $.ajax({
            url: "{{ route('user.carCalculator.getModels') }}",
            method: "GET",
            data: {
                _token: '{{ csrf_token() }}',
                make: make
            },
            success: function(response) {
                if (response) {
                    $('#ni-car-model').empty();
                    $('#ni-car-model').append('<option value="">Select Model</option');
                    $.each(response, function(index, value) {
                        var newOption = new Option(value, index, false, false);
                        $('#ni-car-model').append(newOption).trigger('change');
                    });
                }
            }
        });
    });

    })
</script>
@endpush