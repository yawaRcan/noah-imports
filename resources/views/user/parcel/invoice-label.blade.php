<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tracking - AWB479C28E</title>

    <!-- Prevent the demo from appearing in search engines (REMOVE THIS) -->
    <meta name="robots" content="noindex">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <!-- FAVICON -->
    <link href="https://n.test/upload/default/favicon.png" rel="icon" type="image/png">
    <!-- Custom label-->
    <link type="text/css" href="{{asset('Tracking/custom_label.css')}}" rel="stylesheet">

</head>

<body data-new-gr-c-s-check-loaded="14.1111.0" data-gr-ext-installed="">
    <div id="page-wrap">
        <div class="container_etiqueta" style="margin: 20px auto 0 auto; min-width: 420px; max-width: 420px;">
            <div class="print_ticket_zebra" style="max-height: 110px; min-height: 110px;">
                <div style="width: 30%; line-height:110px; margin:0px auto; text-align:center;">
                    <img class="logo" style="vertical-align:middle" src="{{asset('Tracking/logo.png')}}" width="145" height="70" alt="Noah Imports">
                </div>
                <div style="width: 70%;">
                    <strong>{{general_setting('setting')->site_name ?? 'Noah Imports'}}<br></strong>
                    7640 NW 63rd St, Miami FL 33195-3609<br>
                    Phone: +13057176200
                </div>
            </div>
            <div class="app_print_ticket_zebra" style="margin: -18px 0 15px 22px; height: 100px; max-width: 420px;"> 
                
                <img style="width: 380px; min-height: 100px; max-height: 100px;" src="data:image/png;base64,{{DNS1D::getBarcodePNG($invoice->waybill, 'C39')}}" alt="barcode" />
                
            </div>
            <div class="app_easypack_ticket_zebra" style="padding-top:50px; max-width: 420px; text-align: center">
                <div class="track_courier">
                    <strong>{{$invoice->waybill ?? 'N/A'}}</strong>
                </div>
            </div>

            <div class="app_easypack_print" style="padding-top: 5px; font-weight: bold">
                <div>Package ref: {{$invoice->created_at ?? 'N/A'}}:</div>
            </div>

            <div class="datas_easypack_print">
                <div>Date: {{$invoice->es_delivery_date ?? 'N/A'}} | Qty: {{$invoice->quantity ?? 'N/A'}} | W: {{$invoice->weight ?? 'N/A'}} | <strong>Total</strong>: <span style="color: green">ƒ {{number_format($total['total'], 2) ?? '0.00'}}</span></div>
            </div>

            <div class="app_easypack_print">
                <div>L : {{$invoice->length ?? '0'}} &nbsp;</div>
                <div>
                    W : {{$invoice->width ?? '0'}} &nbsp; H : {{$invoice->height ?? '0'}} &nbsp; </div>
            </div>

            <div class="app_easypack_print">
                <div>
                    <strong>
                        REF. SERVICE:
                    </strong>&nbsp;
                </div>
                <div>
                {{$invoice->freight_type == 'air-freight' ? 'Air Freight' : 'Sea Freight' ?? 'N/A'}} Delivery | {{$invoice->externalShipper->name ?? 'N/A'}} </div>
            </div>

            <div class="app_easypack_ticket_zebra" style="padding: 3px 0; font-size: 22px; 
                max-height: 18px; min-height: 25px;">
                <strong>{{$invoice->payment->name ?? 'N/A'}} </strong>
            </div>

            <br>
            <div class="app_easypack_ticket_zebra" style="font-size: 27px; margin: 17px 0 10px 0; ">
                <strong>{{$invoice->fromCountry->name ?? 'N/A'}} </strong>
            </div>

            <div class="app_easypack_qr_code" style="max-height: 110px; min-height: 110px;">
                <div style="width: 30%;">
                    {!! $QRcode !!}
                </div>
                <div style="width: 70%;">
                {{$invoice->fromCountry->name ?? 'N/A'}}<br>
                {{$invoice->reciever->address ?? 'N/A'}}<br>
                    +{{$invoice->reciever->country_code ?? '1'}}{{$invoice->reciever->phone ?? 'N/A'}}
                </div>
            </div>
        </div>
        
        <br><br><br>
        <button class="print-preview button -dark center no-print" style="font-size:16px">
            Print
            &nbsp;
            <li class="fa fa-print">
            </li>
        </button>
        </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Print Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
    <script>
        $(function() {
            $(".print-preview").on('click', function() {
                return $("#page-wrap").printThis({
                    importCSS: true,
                    loadCSS: "",
                    header: "",
                    header: null, // prefix to html
                    footer: null
                });
            });
        });
    </script>


</body>

</html>