<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tracking - {{$order->order_number ?? 'N/A'}}</title>

</head>

<!-- FAVICON -->
<link href="https://business.noahimports.com/upload/16286381139F9C63509D8385C.PNG" rel="icon" type="image/png">


<!-- Custom invoice -->
<link type="text/css" href="{{asset('Tracking/custom_invoice.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

<body data-new-gr-c-s-check-loaded="14.1111.0" data-gr-ext-installed="">

    <section class="my-account" id="page-wrap" style="position: relative; padding-top: 50px; padding-bottom: 50px;">
        <div class="">
            <div class="row">
                <div class="confirm-payment" style="padding: 15px 25px; border: 1px solid #eeeeee; margin-bottom: 30px; width: 100%; 
                    max-width: 700px; margin-left: auto; margin-right: auto; position: relative; box-shadow: 0px 0px 15px #eeeeee;">

                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td colspan="" style="border: 0; width: 25%;">
                                    <img src="{{asset('assets/images/insurance_logo.png')}}" width="100">
                                </td>
                                <td colspan="" style="border: 0;  text-align: center; width: 50%;">
                                    {{general_setting('setting')->site_name ?? 'Noah Imports'}} <br>
                                    E-mail:
                                    {{general_setting('setting')->email ?? 'noahimports@noah.com'}} <br>
                                    Address:
                                    {{general_setting('smtp')->address ?? 'noahimports@noah.com'}}
                                </td>
                                <td colspan="" style="border: 0; text-align: right; width: 25%;">
                                    {!! $barcode !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>


                    <h1 style="font-size: 25px; font-weight: bold; text-transform: uppercase;">
                        Thank you </h1>

                    <p>Your order has been received and it's been processed. We have sent you a confirmation message with a copy of your receipt to the mail address you provided.</p>
                    <p>Your order will be delivered to the address you provided by our courier partners. You will receive shipping details when we ship your order.</p>

                    <hr style="left: 0; right: 0; margin-top: 50px; margin-bottom: 20px; border: 1px dotted grey;">

                    <h3 style="font-weight: bold; text-transform: uppercase; font-size: 30px; margin-bottom: 40px;">
                        Order summary </h3>

                    <table class="table confirm-table1 table-striped" style="text-align: center; margin-bottom: 40px; width: 100%;" width="100%" align="center">
                        <thead style="background-color: rgba(238, 110, 60, 0.91);" bgcolor="rgba(238, 110, 60, 0.91)">
                            <!-- rgba(255, 107, 17, 0.91) -->
                            <tr>
                                <th style="text-align: center; color: #fff; font-weight: bold;" align="center">
                                    Order no:
                                </th>
                                <th style="text-align: center; color: #fff; font-weight: bold;" align="center">
                                    Date ordered:
                                </th>
                                <th style="text-align: center; color: #fff; font-weight: bold;" align="center">
                                    Payment method:
                                </th>
                                <th style="text-align: center; color: #fff; font-weight: bold;" align="center">
                                    Payment status:
                                </th>
                            </tr>
                        </thead>


                        <tbody>
                            <tr>
                                <td class="confirm-table1-order" style="font-weight: bold; color: #580000; font-size: 15px;">{{$order->order_number ?? 'N/A'}}</td>
                                <td>{{$order->created_at ? date('d-m-Y', strtotime($order->created_at)) : 'N/A'}}</td>
                                <td>{{$order->payment->name ?? 'N/A'}}</td>
                                <td>{{$order->paymentStatus->name ?? 'N/A'}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2 style="font-weight: bold; text-transform: uppercase; font-size: 20px;">Shipping address</h2>

                    <p style="font-size: 15px;">
                        Name: {{$order->shipperAddress->name ?? 'N/A'}}</p>
                    <p style="font-size: 15px;">
                        {{$order->shipperAddress->country->name ?? 'N/A'}} | {{$order->shipperAddress->address ?? 'N/A'}},{{$order->shipperAddress->state ?? 'N/A'}} |

                        {{$order->shipperAddress->phone ?? 'N/A'}}
                    </p>


                    <table class="table confirm-table2 table-hover table-bordered" style="text-align: center; margin-bottom: 40px; 
                        margin-top: 50px; width: 100%;" width="100%" align="center">

                        <thead style="background-color: rgba(236, 236, 236, 0.3);" bgcolor="rgba(236, 236, 236, 0.3)">
                            <tr>
                                <th colspan="2" style="color: #000; font-weight: bold; text-transform: uppercase; 
                                    text-align: left;" align="left" width="20%">
                                    Name </th>
                                <th colspan="2" style="color: #000; font-weight: bold; text-transform: uppercase; 
                                    text-align: left;" align="left" width="20%">
                                    image </th>
                                <th style="text-align: center; color: #000; font-weight: bold; text-transform: uppercase;" align="center" width="5%">
                                    Size </th>
                                <th style="text-align: center; color: #000; font-weight: bold; text-transform: uppercase;" align="center" width="5%">
                                    Quantity </th>
                                <th style="color: #000; font-weight: bold; text-transform: uppercase; text-align: right;" align="right" width="15%">
                                    Price </th>
                            </tr>
                        </thead>

                        <tbody>


                            @foreach($carts as $key => $cart)
                            <tr>
                                <style> 
                                </style>
                                <td colspan="2" class="text-minimize" style="text-align: left;">{{$cart->product->title ?? 'N/A'}}</td>
                                <td colspan="2" style="text-align: left;">
                                    <img src="{{asset('storage/assets/product')}}/{{$cart->product->files[0]->hash_name}}" alt="" width="40px">
                                </td>
                                <td colspan="" style="text-align: left;">{{$cart->product->size ?? 'N/A'}}</td>
                                <td colspan="" style="text-align: left;">{{$cart->quantity ?? 'N/A'}}</td>
                                <td colspan="" style="text-align: left;">{{$cart->currency->symbol ?? 'N/A'}} {{$cart->price ?? 'N/A'}}</td>
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="5" class="text-right text-black-70 pd-20">
                                    <strong>Shipping price</strong>
                                </td>
                                <td colspan="2" style="width: 120px;" class="text-right">
                                    <strong>
                                        {{$order->currency->symbol ?? 'N/A'}} {{$cal->shipping ?? 'N/A'}}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right text-black-70 pd-20">
                                    <strong>Tax</strong>
                                </td>
                                <td colspan="2" style="width: 120px;" class="text-right">
                                    <strong>
                                        {{$order->currency->symbol ?? 'N/A'}} {{$cal->tax ?? 'N/A'}}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right text-black-70 pd-20">
                                    <strong>Items Price</strong>
                                </td>
                                <td colspan="2" style="width: 120px;" class="text-right">
                                    <strong>
                                        {{$order->currency->symbol ?? 'N/A'}}
                                        {{$cal->total ?? 'N/A'}}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right text-black-70 pd-20">
                                    <strong>
                                        Items Price & Administration Fee & Paypal
                                    </strong>
                                </td>
                                <td colspan="2" style="width: 120px;" class="text-right">
                                    <strong>
                                        {{$order->currency->symbol ?? 'N/A'}}
                                        {{$cal->adminFee ?? 'N/A'}}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right text-black-70 pd-20">
                                    <strong>Total</strong>
                                </td>
                                <td colspan="2" class="text-right">
                                    <strong>
                                        {{$order->currency->symbol ?? 'N/A'}}
                                        {{$cal->tenOrderFee ?? 'N/A'}}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right text-black-70 pd-20">
                                    <strong>Total converted</strong>
                                </td>
                                <td colspan="2" style="width: 120px;" class="text-right">
                                    <strong>
                                        ƒ
                                        {{$cal->totalConverted ?? 'N/A'}}
                                        ANG
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <br><br><br><br>
            </div>


            <button class="print-preview button -dark center no-print" style="font-size:16px">
                Print
                &nbsp;
                <li class="fa fa-print">
                </li>
            </button>
            <br><br><br>
        </div>
    </section>


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