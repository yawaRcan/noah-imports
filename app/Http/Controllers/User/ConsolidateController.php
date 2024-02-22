<?php

namespace App\Http\Controllers\User;

use App\Events\ConsolidateEvent;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Models\Admin;
use App\Models\Parcel;
use App\Events\ParcelEvent;
use App\Models\Consolidate;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use App\Models\ParcelImage;
use App\Traits\AirCalculator;
use App\Traits\SeaCalculator;
use App\Models\ConsolidateImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ConsolidateController extends Controller
{
    use AirCalculator, SeaCalculator;

    protected   $parcelArr = array();
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.consolidate.index');
    }

    public function store(Request $request)
    {
        $parcelsCount =  Parcel::whereNotNull('freight_type')->whereIn('id',$request->arr)->count();

        if(count($request->arr) != $parcelsCount){
            $notify = [
                'error' => "Select parcels with complete data",
            ];
            return $notify;
        } 


        $parcel =  Parcel::findOrFail($request->arr[0]);

        $id = Consolidate::orderBy('id', 'desc')->pluck('id')->first();

        if ($id) {
            $id = $id + 1;
        } else {
            $id = 1;
        }


        $Consolidate = new Consolidate();

        $Consolidate->user_id = $parcel->user_id;

        $Consolidate->invoice_no = general_setting('setting')->invoice_no . $id;

        $Consolidate->waybill = general_setting('setting')->waybil_no . $id;

        $Consolidate->external_waybill = 0;

        $Consolidate->reciever_address_id = $parcel->reciever_address_id;

        $Consolidate->sender_address_id = $parcel->sender_address_id;

        $Consolidate->branch_id = $this->branch =  $parcel->branch_id;

        $Consolidate->from_country_id = $parcel->from_country_id;

        $Consolidate->to_country_id = $parcel->to_country_id;

        $Consolidate->external_shipper_id = $parcel->external_shipper_id;

        $Consolidate->freight_type = $parcel->freight_type;

        $Consolidate->shipment_type_id = $parcel->shipment_type_id;

        $Consolidate->shipment_mode_id = $parcel->shipment_mode_id;

        $Consolidate->delivery_method = $parcel->delivery_method;

        $Consolidate->pickup_station_id = $parcel->pickup_station_id;

        $Consolidate->parcel_status_id = $parcel->parcel_status_id;

        $Consolidate->payment_status_id = 3;

        $Consolidate->external_tracking = $parcel->external_tracking;

        $Consolidate->es_delivery_date = $parcel->es_delivery_date;

        $Consolidate->payment_id = $parcel->payment_id;

        $Consolidate->important = 1;

        $Consolidate->show_invoice = 1;

        $Consolidate->show_delivery_date = 1;

        // $Consolidate->amount_total =  0;

        $Consolidate->save();

        $Consolidate->parcels()->attach($request->arr);

        $admin = Admin::first();
   
        $user = User::findOrFail($Consolidate->user_id);

        $template = EmailTemplate::where('slug', 'new-consolidate')->first();

        if ($template) {

            $shortCodes = [
                    'tracking_no' => $Consolidate->external_tracking,
                    'delivery_time' =>  $Consolidate->es_delivery_date,
                    'invoice_url' => route('user.consolidate.invoice', ['id' => $Consolidate->id]),
                ];

            //Send notification to user
            event(new ConsolidateEvent($template , $shortCodes, $Consolidate, $admin, 'CreateConsolidate'));

            //Send notification to user
            event(new ConsolidateEvent($template , $shortCodes, $Consolidate, $user, 'CreateConsolidate')); 

        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
        }  

        $Consolidate->amount_total =  $this->consolidateCalc($Consolidate)['total'];

        $Consolidate->save();

        $template = EmailTemplate::where('slug', 'consolidate-parcel')->first();

        if ($template) {

            $shortCodes = [
                    'tracking_no' => $Consolidate->external_tracking,
                    'delivery_time' =>  $Consolidate->es_delivery_date,
                    'invoice_url' => route('consolidate.invoice', ['id' => $Consolidate->id]),
                ];

            //Send notification to user
            event(new ParcelEvent($template , $shortCodes, $Consolidate, $user, 'ConsolidateParcel')); 

        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
        } 


        $notify = [
            'success' => "Consolidate has been added.",
            'redirect' => route('user.consolidate.index'),
        ];

        return $notify;
    }

        //Get shipping calculator info
        function getShippingCalculator($branch_id, $type, $import, $ob, $length, $width, $height, $actual_weight, $item, $discount, $shipping = 0, $tax = 0)
        {
    
            if ($type == 'air-freight') {
    
                $this->branch =  $branch_id;
    
                $this->weight = $actual_weight;
    
                $this->item = (float) $item;
    
                $this->import_duty = $import;
    
                $this->ob = (float) $ob;
    
                $this->length = (float) $length;
    
                $this->width = (float) $width;
    
                $this->height = (float) $height;
    
                $shipping = (float) $shipping;
    
                $discount = (float) $discount;
    
                $tax = (float) $tax;
    
                $cal = $this->airCalc();
    
                $discount_amount = number_format(($cal['total'] * $discount / 100), 2);
    
                $total = $this->grandTotal($cal['total'], $discount, $shipping, $tax);
    
                $cal['total'] = $cal['total'] + $shipping + $tax;
            } else {
    
                $this->price = (float) $item;
    
                $this->import_duty = $import;
    
                $this->ob = (float) $ob;
    
                $this->length = (float) $length;
    
                $this->width = (float) $width;
    
                $this->height = (float) $height;
    
                $shipping = (float) $shipping;
    
                $discount = (float) $discount;
    
                $tax = (float) $tax;
    
                $cal = $this->seaCalc();
    
                $discount_amount = number_format(($cal['total'] * $discount / 100), 2);
    
                $total = $this->grandTotal($cal['total'], $discount, $shipping, $tax);
    
                $cal['total'] = $cal['total'] + $shipping + $tax;
            }
    
            return ['total' => $total, 'discount' => $discount_amount, 'data' => $cal];
        }
    
        //calculate total
        public function grandTotal($total, $discount = 0, $shipping = 0, $tax = 0)
        {
    
            $discount = ($total * $discount) / 100; //discount is always calculated in percentage
    
            return ($total - $discount) + $shipping + $tax;
        }
    
        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            $consolidate = Consolidate::findOrFail($id);
            $parcels = $consolidate->parcels()->get();
            $total =  $this->consolidateCalc($consolidate, true);
            return view('user.consolidate.show', ['consolidate' => $consolidate, 'parcels' => $parcels, 'total' => $total]);
        }

        public function invoicePrint($id)
        {
    
            // Retrieve the invoice by ID from the database
            $invoice = consolidate::findOrFail($id);
            // Generate a barcode 
            $barcode = $this->generateQRcode($invoice->waybill);
    
            $parcelIds = $invoice->parcels()->pluck('parcel_id');
    
            $parcels = Parcel::select('import_duty_id')
                ->whereIn('id', $parcelIds)
                ->distinct()
                ->pluck('import_duty_id'); 
            foreach ($parcels as $id) {
    
                $arr = Parcel::select(
                    'import_duty_id',   
                    DB::raw('(SELECT ob_fees FROM parcels WHERE import_duty_id = ' . DB::getPdo()->quote($id) . ' AND id IN (' . implode(',', $parcelIds->toArray()) . ') LIMIT 1) AS ob_fees'),
                    DB::raw('SUM(weight) as weight'),
                    DB::raw('SUM(height) as height'),
                    DB::raw('SUM(length) as length'),
                    DB::raw('SUM(width) as width'),
                    DB::raw('SUM(item_value) as item_value'),
                    DB::raw('SUM(delivery_fee) as delivery_fee'),
                    DB::raw('SUM(discount) as discount'),
                    DB::raw('SUM(tax) as tax'),
                    DB::raw('SUM(quantity) as quantity')
                )
                    ->whereIn('id', $parcelIds)->where('import_duty_id', $id)->groupBy('import_duty_id')
                    ->get()->toArray();
                 
                $this->parcelArr = array_merge($this->parcelArr, $arr);
            }
      
            $total =  $this->consolidateCalc($invoice);
    
            $parcels = $this->parcelArr ;
            
            return view('user.consolidate.invoice-print', compact('invoice', 'total', 'barcode', 'parcels'));
        }

        public function generateQRcode($data = null, $barcodeType = null)
        {
    
            $QRData = QrCode::generate($data);;
    
            return $QRData;
        }
    
        function consolidateCalc($invoice, $bol = false)
        {
    
            $parcels = $invoice->parcels()->get()->toArray();
            if (count($this->parcelArr) > 0) {
                $parcels =  $this->parcelArr;
            }
            foreach ($parcels as $key => $value) {
                
                $ship = $this->getShippingCalculator(
                    $invoice->branch_id,
                    $invoice->freight_type,
                    $value['import_duty_id'],
                    $value['ob_fees'],
                    $value['length'],
                    $value['width'],
                    $value['height'],
                    $value['weight'],
                    $value['item_value'],
                    $value['discount'],
                    $value['delivery_fee'],
                    $value['tax']
                );
     
                $insurance[] = $ship['data']['insurance'];
                $clearance_charges[] = $ship['data']['clearance_charges'];
                $import_duty[] = $ship['data']['import_duty'];
                $import_duty_percent[] = $this->airImportDutyData($value['import_duty_id'])->value;
                $import_duty_name[] = $this->airImportDutyData($value['import_duty_id'])->name;
                $ob[] = $ship['data']['ob'];
                $ob_fees[] = $value['ob_fees'];
                $discount[] = $value['discount'];
                $tax[] = $value['tax'];
                $discount_main[] = $ship['discount'];
                $delivery_fee[] = $value['delivery_fee'];
                if ($bol) {
                    $total[$key] = $ship['total'];
                } else {
                    $total[] = $ship['total'];
                }
    
                $data_total[] = $ship['data']['total'];
                $invoice->freight_type == 'air-freight' ?
                    $amount[$key] =  $ship['data']['chargeable_weight_amount'] :
                    $amount[$key] =  $ship['data']['chargeable_dimension'];
            }
    
            if ($bol) {
                return  $data['total'] = $total;
            }
            // dd($import_duty,$import_duty_percent);
            return $data['total'] =   [
                'insurance' => array_sum($insurance),
                'clearance_charges' => array_sum($clearance_charges),
                'import_duty' => $import_duty,
                'import_duty_percent' => $import_duty_percent,
                'import_duty_name' => $import_duty_name,
                'ob_fees' => $ob_fees,
                'ob' => $ob,
                'discount' => array_sum($discount),
                'tax' => array_sum($tax),
                'discount_main' => array_sum($discount_main),
                'delivery_fee' => array_sum($delivery_fee),
                'total' => array_sum($total),
                'data_total' => array_sum($data_total),
                'freight' => $amount
            ];
        }
    
        public function data(Request $request)
        {
    
            if(isset($request->user_id) && $request->user_id != '' && $request->user_id != null){
                $data = Consolidate::where('user_id',$request->user_id)->get();
            }else{
                $data = Consolidate::where('user_id',Auth::guard('web')->user()->id)->get();
            }
    
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown dropstart">
                    <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-sm">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>print
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin: 0px;">
                        <li><a class="dropdown-item consolidate-data-view" href="' . route('user.consolidate.show', [$row->id]) . '" data-consolidate-id=' . $row->id . '>View</a></li> 
                        <li><a class="dropdown-item consolidate-data-invoice" href="' . route('user.consolidate.invoice', [$row->id]) . '" target="_blank">Print Invoice</a></li> 
                    </ul>
                </div>';
                    return $actionBtn;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('status', function ($row) {
    
                    $html = $row->parcelStatus->name;
                    if (isset($row->parcelStatus->color)) {
                        $html = '<span class="mb-1 badge" style="background-color:' . $row->parcelStatus->color . '">' . $row->parcelStatus->name . '</span>';
                    }
                    return $html;
                }) 
                ->addColumn('payment', function ($row) {
                    if ($row->paymentStatus->slug == 'paid') {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-success" data-consolidate-id="' . $row->id . '">' . $row->paymentStatus->name . '</span>&nbsp;<img class="ni-payment-show-modal" data-consolidate-id="' . $row->id . '" src="'.asset("assets/icons/" . $row->payment->icon).'" width="30px" /></a>';
                    } else {
                        $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-danger" data-consolidate-id="' . $row->id . '">Unpaid</span>&nbsp;<img class="ni-payment-show-modal" data-consolidate-id="' . $row->id . '" src="'.asset("assets/icons/" . $row->payment->icon).'" width="30px" /></a>';
                    }
                    return $html;
                })
                ->addColumn('amount', function ($row) {
    
                    $total =  $this->consolidateCalc($row);
    
                    return number_format($total['total'], 2);
                })
                ->addColumn('reciever', function ($row) {
                    return (isset($row->reciever->address) ? $row->reciever->address : 'N/A');
                })
                ->addColumn('sender', function ($row) {
    
                    return (isset($row->sender->address) ? $row->sender->address : 'N/A');
                })
                ->addColumn('waybill', function ($row) {
                    return (isset($row->waybill) ? $row->waybill : 'N/A');
                })
                ->addColumn('invoice', function ($row) {
                    return (isset($row->invoice_no) ? $row->invoice_no : 'N/A');
                })
                ->rawColumns(['action', 'created_at', 'status', 'payment', 'amount',  'reciever', 'sender', 'invoice'])
                ->make(true);
        }
    
        public function imagesGet($id)
        {
    
            $consolidate = Consolidate::findOrFail($id);
            $parcelIds = $consolidate->parcels->pluck('id');
            $images = ParcelImage::whereIn('parcel_id', $parcelIds)->get();

            return view('user.consolidate.images', compact('images'));
        }

        public function getPaymentHtml($id)
        {
    
            $payment = Consolidate::select('id', 'payment_status_id', 'payment_receipt')->where('id', $id)->first();
    
            $paymentStatuses = PaymentStatus::get();
    
            return view('user.consolidate.ajax.payment', ['payment' => $payment,'paymentStatuses' => $paymentStatuses]);
        }

        public function updateDeliveryDate(Request $request)
        {
            if($request->eventType == 'consolidate'){

                $id = str_replace('c-','',$request->id);
                $consolidate = Consolidate::findOrFail($id);
                $consolidate->es_delivery_date = $request->droppedDate;
                $consolidate->save();
            }

            $notify = ['success' => "Consolidate delivery date updated successfully"];

            return $notify;
        }
    
    
}
