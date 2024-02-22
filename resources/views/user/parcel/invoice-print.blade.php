<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tracking - {{$invoice->waybill ?? 'N/A'}}</title>

</head>

<!-- FAVICON -->
<link href="https://business.noahimports.com/upload/16286381139F9C63509D8385C.PNG" rel="icon" type="image/png">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
<!-- Custom invoice -->
<link type="text/css" href="{{asset('Tracking/custom_invoice.css')}}" rel="stylesheet">

<body data-new-gr-c-s-check-loaded="14.1111.0" data-gr-ext-installed="">

    <!-- Prevent the demo from appearing in search engines (REMOVE THIS) -->
    <meta name="robots" content="noindex">



    <!-- FAVICON -->
    <link href="https://business.noahimports.com/upload/16286381139F9C63509D8385C.PNG')}}" rel="icon" type="image/png">
    <div id="page-wrap">
        <link rel="stylesheet" type="text/css" media="print" href="{{asset('css/print-styles.css')}}">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="border: 0;  text-align: left" width="18%">
                        <div id="logo">
                            <img src="{{asset('Tracking/1628638113797EA71B4AE5CDE.PNG')}}" alt="Noah Imports" width="150">
                        </div>
                    </td>
                    <td style="border: 0;  text-align: center" width="56%">
                        {{general_setting('setting')->site_name ?? 'Noah Imports'}} <br>
                        E-mail:
                        {{general_setting('setting')->email ?? 'noahimports@noah.com'}} <br>
                        Address:
                        {{general_setting('smtp')->address ?? 'noahimports@noah.com'}}
                    </td>
                    <td style="border: 0;  text-align: center" width="48%">
                        <br> 
                        <div class="mb-2"> 
                        {!! $barcode !!}
                        </div>
                         
                        <strong style="font-size: 17px;font-weight: bold;">{{$invoice->waybill ?? 'N/A'}}</strong>
                    </td>

                </tr>
            </tbody>
        </table>

        <hr>
        <br>

        <div id="customer">
            <table id="meta">
                <tbody>
                    <tr>
                        <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="62%">

                            @if($invoice->paymentStatus->slug == 'paid')
                            <div style="background: green; color: white;text-align: center;font-weight: 700; width:100px">
                                Paid
                            </div>
                            @else
                            <div style="background: #ff3916; color: white;text-align: center;font-weight: 700; width:100px">
                                Unpaid
                            </div>

                            @endif

                            <strong>
                                Bill to </strong>
                            <br>
                            {{$invoice->full_name ?? 'N/A'}}<br>
                            {{$invoice->reciever->address ?? 'N/A'}} | {{$invoice->reciever->phone ?? 'N/A'}} <br>
                            {{$invoice->reciever->email ?? 'N/A'}} <br><br><br><strong>Delivery address</strong><br>
                            {{$invoice->reciever->address ?? 'N/A'}} <br><br>
                            <table id="items">
                            </table>
                        </td>
                        <td class="meta-head">
                            <p style="color:white;">Payment method</p>
                        </td>
                        <td>
                            {{$invoice->payment->name ?? 'N/A'}}
                        </td>
                    </tr>
                    <tr>
                        <td class="meta-head">
                            <p style="color: white;">Courier company</p>
                        </td>
                        <td>{{$invoice->externalShipper->name ?? 'N/A'}}</td>
                    </tr>
                    <tr>
                        <td class="meta-head">
                            <p style="color:white;">Date</p>
                        </td>
                        <td>{{$invoice->es_delivery_date ?? 'N/A'}}</td>
                    </tr>
                    <tr>
                        <td class="meta-head">
                            <p style="color:white;">Invoice No</p>
                        </td>
                        <td><b>{{$invoice->invoice_no ?? 'N/A'}}</b></td>
                    </tr>
                    <tr>
                        <td class="meta-head">
                            <p style="color:white;">Waybill No</p>
                        </td>
                        <td><b>{{$invoice->waybill ?? 'N/A'}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table id="items">
            <tbody>
                <tr>
                    <th style="color:white;" width="5%"><b>Quantity</b></th>
                    <th style="color:white;" width="30%"><b>Description</b></th>
                    <th style="color:white;" width="20%"><b>Category</b></th>
                    <th style="color:white;" width="10%"><b>Weight (LB)</b></th>
                    <th style="color:white;" width="5%"><b>Length (inch)</b></th>
                    <th style="color:white;" width="5%"><b>Width (inch)</b></th>
                    <th style="color:white;" width="5%"><b>Height (inch)</b></th>
                    <th style="color:white;" width="20%" class="text-center"><b>Total</b></th>
                </tr>

                <tr class="item-row">
                    <td class="text-center">{{$invoice->quantity ?? 'N/A'}}</td>
                    <td>{{$invoice->product_description ?? 'N/A'}}</td>
                    <td>
                        {{$invoice->duty->name ?? 'N/A'}}
                    </td>
                    <td class="text-center">{{$invoice->weight ?? '0'}}</td>
                    <td class="text-center">{{$invoice->length ?? '0'}}</td>
                    <td class="text-center">{{$invoice->width ?? '0'}}</td>
                    <td class="text-center">{{$invoice->height ?? '0'}}</td>
                    <td class="text-center">
                        ƒ {{$invoice->freight_type == 'air-freight' ? $total['data']['chargeable_weight_amount'] : $total['data']['chargeable_dimension'] ?? '0.00'}} </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <strong>Freight type</strong> :
                        {{$invoice->freight_type ?? 'N/A'}}
                    </td>
                    <td colspan="3" class="text-right"><b>
                            Insurance </b>
                    </td>
                    <td class="text-center" id="insurance">
                        ƒ {{number_format($total['data']['insurance'], 2) ?? '0.00'}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="text-right"><b>
                            {{$invoice->freight_type == 'air-freight' ? 'Air clearance charges' : 'Sea clearance charges'}}</b>
                    </td>
                    <td class="text-center" id="total_envio">
                        ƒ {{number_format($total['data']['clearance_charges'], 2) ?? '0.00'}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="text-right"><b>
                            Duty cost {{$invoice->duty->value ?? '0'}} %</b>
                    </td>
                    <td class="text-center" id="total_envio">
                        ƒ {{number_format($total['data']['import_duty'], 2) ?? '0.00'}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="text-right"><b>
                            OB {{$invoice->ob_fees ?? '0'}} %</b>
                    </td>
                    <td class="text-center" id="total_envio">
                        ƒ {{number_format($total['data']['ob'], 2) ?? '0.00'}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="text-right"><b>
                            Delivery fee</b>
                    </td>
                    <td class="text-center" id="total_envio">
                        ƒ {{number_format($invoice->delivery_fee, 2) ?? '0.00'}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="text-right"><b>
                            Tax</b>
                    </td>
                    <td class="text-center" id="total_envio">
                        ƒ {{number_format($invoice->tax, 2) ?? '0.00'}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="text-right"><b>
                            Discount %</b>
                    </td>
                    <td class="text-center" style=" {{ $total['discount'] > 0 ? 'text-decoration: line-through; color: red;' : '' }}">
                        ƒ {{number_format($total['discount'], 2) ?? '0.00'}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="text-right"><b>
                            Grand total</b>
                    </td>
                    <td class="text-center" id="total_envio">
                        ƒ {{number_format($total['total'], 2) ?? '0.00'}} </td>
                </tr>



            </tbody>
        </table>

        <!-- end related transactions -->
        <div id="terms">
            <h5>Terms</h5>
            <div style="width: 100%; text-align: left">
                {{general_setting('setting')->invoice_disclaimer ?? 'NA'}}
            </div>
            <table id="related_transactions" style="width: 100%; text-align: left">

            </table>
        </div>
        <div class="row mt-4">
            <div class="col-6 p-2 border-top">
                <span class="">COMPANY SIGNATURE</span>
            </div>
            <div class="col-6 text-end p-2 border-top">
                <span class="">SIGNATURE / SEAL WHO RECEIVES</span>
            </div>
        </div>


        <button class="print-preview button -dark center no-print" style="font-size:16px">
            Print
            &nbsp;
            <span class="fa fa-print">
            </span >
        </button>
        <br><br><br>
    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Print Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>

    <!-- Components -->


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