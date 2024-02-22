<style>
    .styled-table {
        border-collapse: collapse;
        font-size: 0.9em;
        font-family: sans-serif;
        width: 100%;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }

    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }

    .text-green {
        font-weight: bold;
        color: #009879;
    }
</style>

<div class="row">
    <div class="col-12 table-responsive">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Category</th>
                    <th>Freight</th>
                    <th>Weight</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Dimension</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parcels as $key => $value)
                <tr class="active-row">
                    <td>{{$value->invoice_no ?? 'N/A'}}</td>
                    <td>{{$value->duty->name ?? 'N/A'}}</td>
                    <td>{{$value->duty->freight_type ?? 'N/A'}}</td>
                    <td>{{$value->weight ?? 'N/A'}}</td>
                    <td>{{$value->length ?? 'N/A'}}</td>
                    <td>{{$value->width ?? 'N/A'}}</td>
                    <td>{{$value->height ?? 'N/A'}}</td>
                    <td>{{$value->dimension ?? 'N/A'}}</td>
                    <td>ƒ{{ number_format($total[$key],2) ?? 'N/A'}}</td>
                </tr>
                @endforeach
                <!-- and so on... -->
            </tbody>
        </table>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="floating-labels mt-4">
                <div class="form-group">
                    <input type="number" class="form-control" id="ni-paid-input">
                    <span class="bar"></span>
                    <label for="ni-paid-input">Paid JIMP</label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="floating-labels mt-4">
                <div class="form-group ">
                    <input type="number" class="form-control" id="ni-ship-input">
                    <span class="bar"></span>
                    <label for="ni-ship-input">Ship to JIMP</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mt-2 col-sm-6 col-6 shadow card-hover">
                            <div class="text-green">Total Amount</div>
                            <div class="fw-bold ni-total">ƒ{{$totalConverted}}</div>
                        </div>
                        <div class="col-md-3 mt-2 col-sm-6 col-6 shadow card-hover">
                            <div class="text-green">Mia-JIMP-Curacao</div>
                            <div class="fw-bold">ƒ<span class="ni-jimp">0</span></div>
                        </div>
                        <div class="col-md-3 mt-2 col-sm-6 col-6 shadow card-hover">
                            <div class="text-green">Credit</div>
                            <div class="fw-bold">ƒ<span class="ni-credit">0</span></div>
                        </div>
                        <div class="col-md-3 mt-2 col-sm-6 col-6 shadow card-hover">
                            <div class="text-green">Saving</div>
                            <div class="fw-bold">ƒ<span class="ni-saving">0</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.form-control').on('blur', function() {

        if ($("#ni-paid-input").val() == '') {
            $("#ni-paid-input").closest('div').removeClass('focused');
        }
        if ($("#ni-ship-input").val() == '' || $("#ni-ship-input").val() == 'undefined' || $("#ni-ship-input").val() == null) {
            $("#ni-ship-input").closest('div').removeClass('focused');
        }

    })
    $('.form-control').on('click', function() {
        $(this).closest('div').addClass('focused');
    });

    $('#ni-paid-input').on('keyup', function() {

        if ($("#ni-paid-input").val() != '' && $("#ni-ship-input").val() != '') {
           
            var url = "{{route('parcel.calAjax.data')}}";
            data = {
                'paid': $("#ni-paid-input").val(),
                'ship': $("#ni-ship-input").val(),
                'total': '{{$totalConverted}}'
            };
            calAjax(url, data);
        }

    });

    $('#ni-ship-input').on('keyup', function() {

        if ($("#ni-paid-input").val() != '' && $("#ni-ship-input").val() != '' ) {
          
            var url = "{{route('parcel.calAjax.data')}}";
            data = {
                'paid': $("#ni-paid-input").val(),
                'ship': $("#ni-ship-input").val(),
                'total': '{{$totalConverted}}'
            };
            calAjax(url, data);
        }

    });

    function calAjax(url, data) {

        var request = $.ajax({
            url: url,
            method: "GET",
            data: data,
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
        });
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                notify('success', response.success);
            }
            if (response.data) {
                $(".ni-jimp").html(response.data.jimp)
                $(".ni-credit").html(response.data.credit)
                $(".ni-saving").html(response.data.saving)
                $(".ni-total").html('ƒ'+response.data.total) 
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            if (jqXHR.status) {
                notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
            }
        });
    }
</script>