<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;


use Dompdf\Dompdf;

use App\Models\Rate;

use App\Models\User;

use App\Models\Admin;

use App\Models\Branch;

use App\Models\Parcel;

use App\Models\Wallet;

use EasyPost\EasyPost;

use App\Models\Payment;

use Milon\Barcode\DNS1D;

use App\Events\ParcelEvent;

use App\Models\ParcelImage;

use App\Models\ConfigStatus;

use Illuminate\Http\Request;

use App\Models\EmailTemplate;

use App\Models\PaymentStatus;

use App\Models\PickupStation;

use App\Traits\AirCalculator;

use App\Traits\SeaCalculator;

use App\Models\ParcelDelivery;

use App\Models\ShippingAddress;

use App\Services\EasyPostService;

use App\Services\AftershipService;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Facades\DNS1DFacade;
use App\Http\Requests\Admin\Parcel\CreateRequest;
use App\Http\Requests\Admin\Parcel\UpdateRequest;
use App\Notifications\ShipmentCreateNotification;
use App\Http\Requests\Admin\ShipperAddress\StoreRequest;
use App\Http\Requests\Admin\ParcelDelivery\UpdateDeliveryRequest;
use App\Http\Requests\User\ShipperAddress\StoreRequest as AddRecieverRequest;

class ParcelController extends Controller
{
    use AirCalculator, SeaCalculator;

    private $aftershipService;
    private $trackerService;

    public function __construct(AftershipService $aftershipService, EasyPostService $trackerService)
    {
        $this->aftershipService = $aftershipService;
        $this->trackerService = $trackerService;
    }

    public function index()
    {
        // $this->trackerService->template = [
        //    'external_tracking' => 'EZ1000000001',
        //    'carrier' => 'USPS',
        // ]; 
        // $res = $this->trackerService->createLabel(true); //create tracking on api-end-point
        // $res1 = $this->trackerService->viewLabel('trk_e9ce8a69616f43da9e3d5b48ee8eea59'); //this Id parameter is tracking id created by easypost
        // dd($res,$res1);

        $config = 'all';
        $drafted = null;
        $title = 'All Parcels';

        $configstatus = ConfigStatus::pluck('name', 'id');

        return view('admin.parcel.index', ['status' => $config, 'drafted' => $drafted, 'title' => $title, 'configstatus' => $configstatus]);
    }

    public function pendingParcels()
    {
        $config = ConfigStatus::where('slug', 'pending')->first()->id;
        $title = 'Pending Parcels';
        $configstatus = ConfigStatus::pluck('name', 'id');
        return view('admin.parcel.index', ['status' => $config, 'drafted' => null, 'title' => $title, 'configstatus' => $configstatus]);
    }


    public function draftedParcels()
    {
        $drafted = 1;
        $title = 'Drafted Parcels';
        $configstatus = ConfigStatus::pluck('name', 'id');
        return view('admin.parcel.index', ['status' => null, 'drafted' => $drafted, 'title' => $title, 'configstatus' => $configstatus]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shipmentAddress = ShippingAddress::whereHasMorph('morphable', [Admin::class])
            ->where('morphable_id', Auth::user()->id)->get();
        $paymentStatuses = PaymentStatus::get();

        return view('admin.parcel.add', compact('shipmentAddress', 'paymentStatuses'));
    }
    public function addOrderReceipt(Request $request)
    {
        $parcel = Parcel::findOrFail($request->parchase_id);
        $parcel->order_invoice_status = 1;
        $parcel->payment_receipt = $this->fileUpload($request->payment_file);
        $parcel->save();

        $notify = [
            'success' => "Receipt has been Added.",
            'redirect' => route('user.parcel.index'),
            'id' => $parcel->id,
        ];
        return $notify;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        $parcel = Parcel::with('shipmentMode')->findOrFail($id);


        $statuses = ConfigStatus::whereIn('slug', ['pending', 'processing', 'in-transit', 'in-transit-to-be-delivered', 'delivered'])->orderBy('id', 'ASC')->get();
        $onlineTracking = null;
        $lastIndex = '';
        $statusValue = '';
        $onlineStatusesExceptions = [
            ['status' => 'AttemptFail', 'message' => 'Carrier attempted to deliver but failed, and usually leaves a notice and will try to deliver again.'],
            ['status' => 'Exception', 'message' => 'Custom hold, undelivered, returned shipment to sender or any shipping exceptions.'],
            ['status' => 'Expired', 'message' => 'Shipment has no tracking information for 30 days since added.'],
        ];
        $onlineStatuses = [
            ['value' => 1, 'status' => 'Pending', 'message' => 'New shipments added that are pending to track, or new shipments without tracking information available yet.'],
            ['value' => 2, 'status' => 'InfoReceived', 'message' => 'Carrier has received request from shipper and is about to pick up the shipment.'],
            ['value' => 3, 'status' => 'InTransit', 'message' => 'Carrier has accepted or picked up shipment from shipper. The shipment is on the way.'],
            ['value' => 4, 'status' => 'OutForDelivery', 'message' => 'Carrier is about to deliver the shipment , or it is ready to pickup.'],
            ['value' => 5, 'status' => 'Delivered', 'message' => 'The shipment was delivered successfully.'],
            // ['status' =>'AvailableForPickup', 'message' => 'The package arrived at a pickup point near you and is available for pickup.'],
        ];

        $aftershipStatus = general_setting('aftership')->status;

        if ($aftershipStatus == 'on') {
            $onlineTracking = $this->aftershipService->viewLabel($parcel->externalShipper->slug, $parcel->external_tracking);
            // dd($onlineTracking);
            $lastIndex = count($onlineTracking['data']['checkpoints']) - 1;

            foreach ($onlineStatuses as $key => $value) {
                if ($value['status'] == $onlineTracking['data']['tag']) {
                    $statusValue = $value['value'];
                }
            }
        }

        return view('admin.parcel.show', compact('onlineTracking', 'lastIndex', 'onlineStatuses', 'onlineStatusesExceptions', 'statusValue', 'parcel', 'statuses'));
    }

    public function parcelData(Request $request)
    {

        $parcel = Parcel::where('external_tracking', $request->tracking)->first();

        if ($parcel) {

            $notify = [
                'success' => "Parcel tracking already exist fill remaining fields to update.",
                'data' => $parcel,
            ];

            return $notify;
        } else {

            return true;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        ini_set('max_execution_time', 500);
        ini_set('memory_limit', '700M');
        $total = $this->getShippingCalculator(
            $request->branch_id,
            $request->freight_type,
            $request->import_duties,
            $request->ob_fees,
            $request->length,
            $request->width,
            $request->height,
            $request->weight,
            $request->item_value,
            $request->discount,
            $request->delivery_fees,
            $request->tax
        );

        $paymentMethod = Payment::findOrFail($request->payment_method);
        $user = User::findOrFail($request->search_user_id);

        if ($paymentMethod->slug == "account-funds") {
            $userBalance = $user->balance();
            $amount = $total['total'];

            if ($userBalance < 0 || $userBalance < $amount) {
                $notify = ['error' => "Your Account Balance is not enough!"];
                return $notify;
            }
        }

        $parcels = Parcel::where(['external_tracking' => $request->external_tracking])->first();
        $trackFlag = 0;
        if (is_null($parcels)) {

            $id = Parcel::orderBy('id', 'desc')->pluck('id')->first();

            if ($id) {
                $id = $id + 1;
            } else {
                $id = 1;
            }

            $parcels = new Parcel();

            $parcels->invoice_no = general_setting('setting')->invoice_no . $id;

            $parcels->waybill = general_setting('setting')->waybil_no . $id;

            $parcels->orderable_type = 'Default';

            $parcels->orderable_id = 0;

            $trackFlag = 1;
        }

        $parcels->user_id = $request->search_user_id;

        $parcels->full_name = $request->full_name;

        $parcels->external_waybill = $request->external_awb;

        $parcels->reciever_address_id = $request->reciver_ship_address;

        $parcels->sender_address_id = $request->sender_ship_address;

        $parcels->branch_id = $this->branch = $request->branch_id;

        $parcels->from_country_id = $request->from_country;

        $parcels->to_country_id = $request->to_country;

        if ($request->currency_id)
            $parcels->currency_id = $request->currency_id;
        else
            $parcels->currency_id = 2;

        $parcels->external_shipper_id = $request->external_shpper;

        $parcels->freight_type = $request->freight_type;

        $parcels->shipment_type_id = $request->shipment_type;

        $parcels->shipment_mode_id = $request->shipment_mode;

        $parcels->import_duty_id = $request->import_duties;

        $parcels->quantity = (isset($request->quantity) ? $request->quantity : 0);

        $parcels->weight = $this->weight = (isset($request->weight) ? $request->weight : 0);

        $parcels->length = $this->length = (isset($request->length_inch) ? $request->length_inch : 0);

        $parcels->width = $this->width = (isset($request->width_inch) ? $request->width_inch : 0);

        $parcels->height = $this->height = (isset($request->height_inch) ? $request->height_inch : 0);

        $parcels->dimension = (isset($request->dimention) ? $request->dimention : 0);

        $parcels->product_description = $request->product_desc;

        $parcels->delivery_method = $request->delivery_method;

        if ($request->delivery_method > 0) {
            $parcels->pickup_station_id = $request->pickup_station;
        }

        $parcels->delivery_fee = (isset($request->delivery_fees) ? $request->delivery_fees : 0);

        $parcels->discount_type = (isset($request->discount_type) ? $request->discount_type : 'ship');

        $parcels->discount = (isset($request->discount) ? $request->discount : 0);

        $parcels->item_value = (isset($request->item_value) ? $request->item_value : 0);

        $parcels->ob_fees = (isset($request->ob_fees) ? $request->ob_fees : 0);

        $parcels->tax = $request->tax;

        $parcels->parcel_status_id = $request->parcel_status;

        $parcels->external_tracking = $request->external_tracking;

        $parcels->es_delivery_date = $request->estimate_delivery_date;

        $parcels->payment_id = $request->payment_method;

        $parcels->payment_status_id = $request->payment_status;

        if ($request->payment_file) {

            $parcels->payment_receipt = $this->fileUpload($request->payment_file);
        }

        $parcels->comment = $request->comment;

        $parcels->important = ($request->important == 'on') ? 1 : 0;

        $parcels->show_invoice = ($request->show_invoice == 'on') ? 1 : 0;

        $parcels->show_delivery_date = ($request->show_delivery_date == 'on') ? 1 : 0;

        $parcels->amount_total = $total['total'];

        $aftershipStatus = general_setting('aftership')->status;

        if ($trackFlag == 1 && $aftershipStatus == 'on') {
            // Create the shipment
            try {
                // dd($parcels->toCountry->name);
                $this->aftershipService->template = $this->afterShipInfo($parcels);

                $res = $this->aftershipService->createLabel(true, $parcels->external_tracking, true); //create tracking on api-end-point

                if ($res['response'] == 200) { //create tracking status if success

                    $parcels->external_status = $res['message']['data']['tracking']['tag'];
                }
            } catch (\Exception $e) {
                // Handle the error
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $parcels->save();

        // if($balanceFlag){
        //     $wallet = new Wallet();
        //     $wallet->type = 'debit';
        //     $wallet->amount = $amount;
        //     $wallet->description = 'Parcel Amount';
        //     $wallet->status = 'approved';
        //     $wallet->morphable()->associate($user);
        //     $wallet->save();
        // } 

        $admin = Admin::first();

        $user = User::findOrFail($parcels->user_id);

        $template = EmailTemplate::where('slug', 'new-shipment')->first();

        if ($template) {

            $senderName = @$parcels->sender->first_name . ' ' . @$parcels->sender->last_name;
            $shortCodes = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'sender_name' => $senderName,
                'tracking_no' => $parcels->external_tracking,
                'delivery_time' => $parcels->es_delivery_date,
                // 'invoice_url' => route('parcel.getTrackingUser', ['id' => $parcels->id]),
                'invoice_url' => url('/user/parcel/getShipmentStatus/Link/' . $parcels->id),
            ];

            //Send notification to user
            event(new ParcelEvent($template, $shortCodes, $parcels, $admin, 'CreateParcel'));

            //Send notification to user
            event(new ParcelEvent($template, $shortCodes, $parcels, $user, 'CreateParcel'));
        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];

            // return $notify;
        }

        $notify = [
            'success' => "Parcel has been Added.",
            'redirect' => route('parcel.index'),
            'id' => $parcels->id,
        ];

        return $notify;
    }

    public function afterShipInfo($parcels)
    {
        $deliveryDate = date('Y-m-d', strtotime($parcels->es_delivery_date));

        $phone = '+' . $parcels->reciever->country_code . $parcels->reciever->phone;
        return [
            'tracking_number' => $parcels->external_tracking,
            'title' => 'Parcel Shipment',
            'customer_name' => $parcels->full_name,
            'destination_country_iso2' => $parcels->toCountry->code,
            'emails' => [$parcels->reciever->email],
            'smses' => [$phone],
            'order_id' => 'ID ' . $parcels->invoice_no,
            "order_number" => $parcels->invoice_no,
            "order_date" => $parcels->created_at,
            "order_id_path" => "http://www.aftership.com/order_id=" . $parcels->invoice_no,
            "shipment_package_count" => 1,
            "custom_fields" => [
                "product_name" => "$parcels->product_description",
                "product_price" => "USD.$parcels->item_value"
            ],
            "language" => "en",
            "delivery_time" => 9,
            "order_promised_delivery_date" => strval($deliveryDate),
            "delivery_type" => "pickup_at_store",
            "pickup_location" => "Flagship Store",
            'slug' => $parcels->externalShipper->slug, // Carrier slug e.g. 'ups', 'fedex', 'dhl'
            "pickup_note" => $parcels->comment,
            "note" => $parcels->comment,
            'origin_country_iso3' => $parcels->sender->country->iso3,
            "origin_state" => $parcels->sender->state,
            "origin_city" => $parcels->sender->city,
            "origin_postal_code" => $parcels->sender->zipcode,
            "origin_raw_location" => $parcels->sender->address,
            "destination_country_iso3" => $parcels->reciever->country->iso3,
            "destination_state" => $parcels->reciever->state,
            "destination_city" => $parcels->reciever->city,
            "destination_postal_code" => $parcels->reciever->zipcode,
            "destination_raw_location" => $parcels->reciever->address,
        ];
    }

    //Get shipping calculator info
    function getShippingCalculator($branch_id, $type, $import, $ob, $length, $width, $height, $actual_weight, $item, $discount, $shipping = 0, $tax = 0, $discount_type = 'ship')
    {

        if ($type == 'air-freight') {

            $this->branch = $branch_id;

            $this->weight = $actual_weight;

            $this->item = (float) $item;

            $this->import_duty = $import;

            $this->ob = (float) $ob;

            $this->length = (float) $length;

            $this->width = (float) $width;

            $this->height = (float) $height;

            $this->discount_type = $discount_type;

            $shipping = (float) $shipping;

            $discount = (float) $discount;

            $tax = (float) $tax;

            $cal = $this->airCalc();

            if ($this->discount_type == 'ship') {
                $discount_amount = number_format(($cal['total'] * $discount / 100), 2);
            } else {
                $discount_amount = number_format((($cal['total'] + $shipping + $tax) * $discount / 100), 2);
            }

            $total = $this->grandTotal($cal['total'], $discount, $shipping, $tax);

            $cal['total'] = $cal['total'] + $shipping + $tax;
        } else {

            $this->price = (float) $item;

            $this->import_duty = $import;

            $this->ob = (float) $ob;

            $this->length = (float) $length;

            $this->width = (float) $width;

            $this->height = (float) $height;

            $this->discount_type = $discount_type;

            $shipping = (float) $shipping;

            $discount = (float) $discount;

            $tax = (float) $tax;

            $cal = $this->seaCalc();

            if ($this->discount_type == 'ship') {
                $discount_amount = number_format(($cal['total'] * $discount / 100), 2);
            } else {
                $discount_amount = number_format((($cal['total'] + $shipping + $tax) * $discount / 100), 2);
            }


            $total = $this->grandTotal($cal['total'], $discount, $shipping, $tax);

            $cal['total'] = $cal['total'] + $shipping + $tax;
        }

        return ['total' => $total, 'discount' => $discount_amount, 'data' => $cal];
    }

    //calculate total
    public function grandTotal($total, $discount = 0, $shipping = 0, $tax = 0)
    {
        if ($this->discount_type == 'ship') {
            $discount = ($total * $discount) / 100; //discount is always calculated in percentage
            return($total - $discount) + $shipping + $tax;
        } else {
            $total = $total + $shipping + $tax;
            $discount = ($total * $discount) / 100; //discount is always calculated in percentage
            return($total - $discount);
        }
    }

    public function calculateParcel(Request $request)
    {
        $total = [];
        $parcels = Parcel::whereIn('id', $request->parcelIds)->get();
        foreach ($parcels as $key => $value) {
            $total[] = $this->getShippingCalculator(
                $value->branch_id,
                $value->freight_type,
                $value->import_duty_id,
                $value->ob_fees,
                $value->length,
                $value->width,
                $value->height,
                $value->weight,
                $value->item_value,
                $value->discount,
                $value->delivery_fees,
                $value->tax
            )['total'];
        }

        $totalConverted = array_sum($total);

        return view('admin.parcel.calculator', compact('total', 'totalConverted', 'parcels'))->render();
    }

    public function calAjax(Request $request)
    {
        $jimp = $request->paid + $request->ship;
        $credit = $request->total - $jimp;
        $saving = 0.1 * $credit;
        $notify = [
            'success' => "Parcels has been Calculated.",
            'data' => [
                'jimp' => number_format($jimp, 2),
                'credit' => number_format($credit, 2),
                'saving' => number_format($saving, 2),
                'total' => number_format($request->total, 2),
            ],
        ];

        return $notify;
    }

    public function getPayParcelsData(Request $request)
    {
        $total = [];
        $parcels = Parcel::whereIn('id', $request->parcelIds)->where('payment_status_id', 1)->get();
        foreach ($parcels as $key => $value) {
            $total[] = $this->getShippingCalculator(
                $value->branch_id,
                $value->freight_type,
                $value->import_duty_id,
                $value->ob_fees,
                $value->length,
                $value->width,
                $value->height,
                $value->weight,
                $value->item_value,
                $value->discount,
                $value->delivery_fees,
                $value->tax
            )['total'];
        }

        $totalCoverted = array_sum($total);

        return view('admin.parcel.pay-parcel', compact('parcels', 'total', 'totalCoverted'))->render();
    }

    public function payParcelAmount(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $currency_id = Parcel::where('id', $request->parcelIds[0])->pluck('currency_id')->first();
        $itemValue = array_sum($request->item_values);
        $wallet = new Wallet();
        $wallet->payment_id = 4;
        $wallet->currency_id = $currency_id;
        $wallet->type = 'debit';
        $wallet->amount = $itemValue;
        $wallet->amount_converted = $request->amount_converted;
        $wallet->description = 'Parcels Payment';
        $wallet->status = 'approved';
        $wallet->morphable()->associate($user);
        $wallet->save();

        $parcels = Parcel::whereIn('id', $request->parcelIds)->update(['payment_status_id' => 2]);

        $notify = ['success' => "Amount paid successfully!"];
        return $notify;
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $shipmentAddress = ShippingAddress::whereHasMorph('morphable', [Admin::class])
            ->where('morphable_id', Auth::user()->id)->get();

        $parcels = Parcel::findOrFail($id);

        $shipmentAddressRecive = ShippingAddress::whereHasMorph('morphable', [User::class])
            ->where('morphable_id', $parcels->user_id)->get();
        return view('admin.parcel.edit', compact('parcels', 'shipmentAddress', 'shipmentAddressRecive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {

        $parcels = Parcel::with('parcelStatus')->findOrFail($id);

        $parcels->payment_id = $parcels->payment_id;
        $parcels->sender_address_id = $request->sender_ship_address;

        $parcels->reciever_address_id = $request->reciver_ship_address;

        $parcels->external_waybill = $request->external_awb;

        $parcels->full_name = $request->full_name;

        $parcels->branch_id = $request->branch_id;

        $parcels->from_country_id = $request->from_country;

        $parcels->to_country_id = $request->to_country;

        $parcels->external_shipper_id = $request->external_shpper;

        $parcels->freight_type = $request->freight_type;

        $parcels->shipment_type_id = $request->shipment_type;
        if ($request->payment_file) {
            $parcels->payment_receipt = $this->fileUpload($request->payment_file);
        }

        $parcels->shipment_mode_id = $request->shipment_mode;

        if (isset($request->parcel_status) && $parcels->parcel_status_id != $request->parcel_status) {

            $parcels->parcel_status_id = $request->parcel_status;

            $statusFlag = 1;
        } else {
            $statusFlag = 0;
        }

        if ($request->parcel_status == 1)
            $parcels->parcel_status_id = 9;


        $parcels->external_tracking = $request->external_tracking;

        $parcels->es_delivery_date = $request->estimate_delivery_date;

        $parcels->comment = $request->comment;

        $parcels->delivery_method = $request->delivery_method;

        if ($request->delivery_method > 0) {

            $parcels->pickup_station_id = $request->pickup_station;
        }

        $parcels->import_duty_id = (isset($request->import_duties) ? $request->import_duties : 1);

        $parcels->quantity = (isset($request->quantity) ? $request->quantity : 0);

        $parcels->weight = $this->weight = (isset($request->weight) ? $request->weight : 0);

        $parcels->length = $this->length = (isset($request->length_inch) ? $request->length_inch : 0);

        $parcels->width = $this->width = (isset($request->width_inch) ? $request->width_inch : 0);

        $parcels->height = $this->height = (isset($request->height_inch) ? $request->height_inch : 0);

        $parcels->dimension = (isset($request->dimention) ? $request->dimention : 0);

        $parcels->delivery_fee = (isset($request->delivery_fees) ? $request->delivery_fees : 0);

        $parcels->discount_type = (isset($request->discount_type) ? $request->discount_type : 'ship');

        $parcels->discount = (isset($request->discount) ? $request->discount : 0);

        $parcels->item_value = (isset($request->item_value) ? $request->item_value : 0);

        $parcels->ob_fees = (isset($request->ob_fees) ? $request->ob_fees : 1);

        $parcels->tax = (isset($request->tax) ? $request->tax : 0);

        $parcels->product_description = (isset($request->product_desc) ? $request->product_desc : '');

        $parcels->save();

        $parcels->load('parcelStatus');

        $admin = Admin::first();

        $user = User::findOrFail($parcels->user_id);

        if (isset($request->parcel_status) && $statusFlag == 1) {

            $template = EmailTemplate::where('slug', 'parcel-status')->first();

            if ($template) {

                $shortCodes = [
                    'tracking_no' => $parcels->external_tracking,
                    'delivery_time' => $parcels->es_delivery_date,
                    'invoice_url' => route('parcel.invoice', ['id' => $parcels->id]),
                ];

                //Send notification to user
                event(new ParcelEvent($template, $shortCodes, $parcels, $admin, 'ParcelStatus'));

                //Send notification to user
                event(new ParcelEvent($template, $shortCodes, $parcels, $user, 'ParcelStatus'));
            } else {

                $notify = [
                    'error' => "Something went wrong contact your admin.",
                ];
            }
        }

        $template = EmailTemplate::where('slug', 'update-shipment')->first();

        if ($template) {

            $shortCodes = [
                'tracking_no' => $parcels->external_tracking,
                'delivery_time' => $parcels->es_delivery_date,
                'invoice_url' => route('parcel.invoice', ['id' => $parcels->id]),
            ];

            //Send notification to user
            event(new ParcelEvent($template, $shortCodes, $parcels, $admin, 'UpdateParcel'));

            //Send notification to user
            event(new ParcelEvent($template, $shortCodes, $parcels, $user, 'UpdateParcel'));
        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
        }



        $notify = [
            'success' => "Parcel has been Updated.",
            'redirect' => route('parcel.index'),
            'id' => $parcels->id,
        ];


        return $notify;
    }

    public function fileStore(Request $request)
    {
        $this->fileUploadMultiple($request->file, $request->parcel_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        foreach ($request->arr as $arr) {
            //  Parcel::findOrFail($arr)->delete();
        }
        $notify = ['success' => "Parcel has been deleted."];

        return $notify;
    }

    function toDraft(Request $request)
    {

        foreach ($request->arr as $arr) {
            $parcel = Parcel::findOrFail($arr);
            $parcel->drafted_at = Carbon::now()->format('Y-m-d H:i:s');
            $parcel->save();
        }

        $notify = ['success' => "Parcel has been deleted."];

        return $notify;
    }

    public function fileUpload($file, $oldFile = null)
    {
        if (isset($file)) {

            $fileFormats = ['image/jpeg', 'image/png', 'image/gif', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'text/plain'];
            if (!in_array($file->getClientMimeType(), $fileFormats)) {

                // return Reply::error('This file format not allowed');

            }

            if (Storage::exists('assets/payment/' . $oldFile)) {

                Storage::Delete('assets/payment/' . $oldFile);

                $file->storeAs('assets/payment/', $file->hashName());

                return $file->hashName();

                /* 
                  Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            } else {

                $file->storeAs('assets/payment/', $file->hashName());

                return $file->hashName();
            }
        } else {

            return $oldFile;
        }
    }

    public function fileUploadMultiple($files, $id = null)
    {

        if (isset($files)) {

            foreach ($files as $key => $value) {

                $parcelImage = new ParcelImage();

                $parcelImage->name = $value->getClientOriginalName();

                $parcelImage->hash_name = $value->hashName();

                $parcelImage->size = $value->getSize();

                $parcelImage->type = $value->getClientOriginalExtension();

                $parcelImage->parcel_id = $id;

                $parcelImage->save();

                $value->storeAs('assets/parcel/', $value->hashName());
            }
        }
    }

    public function getUsers(Request $request)
    {

        $q = trim($request->q);

        $users = User::select('first_name', 'last_name', 'customer_no', 'email', 'id')->where(function ($query) use ($q) {
            $query->where('first_name', 'LIKE', '%' . $q . '%')
                ->orWhere('last_name', 'LIKE', '%' . $q . '%')
                ->orWhere('customer_no', 'LIKE', '%' . $q . '%')
                ->orWhere('email', 'LIKE', '%' . $q . '%');
        })->get();

        if (count($users) > 0) {

            foreach ($users as $user) {

                $arr[] = (object) [

                    'response' => $user,
                    'id' => $user->id,
                    'first_name' => ucwords($user->first_name),
                    'last_name' => ucwords($user->last_name),
                    'customer_no' => $user->customer_no,
                    'email' => $user->email

                ];
            }
        } else {

            $arr[] = (object) [
                'response' => '',
                'id' => '',
                'first_name' => '',
                'last_name' => '',
                'customer_no' => '',
                'email' => ''
            ];
        }

        return json_encode(['items' => $arr]);
    }

    public function checkReciverAdd(Request $request)
    {
        $arr = '';

        $user = User::select('first_name', 'last_name')->where('id', $request->id)->first();

        $address = ShippingAddress::select('id', 'first_name', 'last_name', 'address')->whereHasMorph('morphable', [User::class])
            ->where('morphable_id', $request->id);

        if (isset($address)) {

            if ($address->count() == 0) {

                $arr = [
                    'error' => "Sorry, there is no address found for this user. Click Add Reciver Address to add address for user.",
                    'full_name' => $user->first_name . ' ' . $user->last_name,
                    'addresses' => $address->get(),
                ];
            } else {

                $arr = [
                    'error' => null,
                    'full_name' => $user->first_name . ' ' . $user->last_name,
                    'addresses' => $address->get(),
                ];
            }
        }
        return $arr;
    }

    public function getRecieverhtml()
    {

        return view('admin.parcel.reciever');
    }

    public function getSenderhtml()
    {
        $senderAddress = ShippingAddress::whereHasMorph('morphable', [Admin::class])->first();

        return view('admin.parcel.sender', compact('senderAddress'));
    }

    public function getPaymentHtml($id)
    {

        $payment = Parcel::select('id', 'payment_status_id', 'invoice_payment_receipt')->where('id', $id)->first();

        $paymentStatuses = PaymentStatus::get();

        return view('admin.parcel.payment', ['payment' => $payment, 'paymentStatuses' => $paymentStatuses]);
    }
    public function showParcelOrderInvoice($id)
    {

        $payment = Parcel::select('id', 'payment_status_id', 'payment_receipt')->where('id', $id)->first();

        $paymentStatuses = PaymentStatus::get();

        return view('admin.parcel.order-invoice', ['payment' => $payment, 'paymentStatuses' => $paymentStatuses]);
    }

    public function getParcelTracking($id)
    {
        $parcel = Parcel::findOrFail($id);

        $param =
            [

                'carrier_id' => "dhl",
                //$parcel->externalShipper->slug,               // the carrier code, you can find from https://app.kd100.com/api-management
                'tracking_number' => $parcel->external_tracking,
                //'9926933413',    
                // The tracking number you want to query
                'phone' => '',                        // Phone number
                'ship_from' => '',                    // City of departure
                'ship_to' => '',                      // Destination city
                'area_show' => 1,                     // 0: close (default); 1: return data about area_name, location, order_status_description
                'order' => 'desc'                     // Sorting of returned results: desc - descending (default), asc - ascending
            ];

        // Request Json
        $key = 'BpRXHMUFjCdp1609';
        $secret = 'e58ea39bb36643288a214aeff5c053f1';
        $json = json_encode($param, JSON_UNESCAPED_UNICODE);
        $signature = strtoupper(md5($json . $key . $secret));

        $url = 'https://www.kd100.com/api/v1/tracking/realtime';    // Real-time shipment tracking request address

        // echo 'request headers key: '.$key;
        // echo 'request headers signature: '.$signature;
        // echo 'request json: '.$json;

        $headers = array(
            'Content-Type:application/json',
            'API-Key:' . $key,
            'signature:' . $signature,
            'Content-Length:' . strlen($json)
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        $deliveryStatus = '';
        $externalTrackingStatusArr = [];
        if ($data['code'] == 200 && isset($data['data'])) {
            //    dd($data['data']['order_status_code']);
            $arr_column = [];
            foreach ($data['data']['items'] as $item) {
                $arr_column[] = $item['order_status_description'];
                if ($item['order_status_code'] == $data['data']['order_status_code']) {
                    $deliveryStatus = $item['order_status_description'];
                }
            }
            $externalTrackingStatusArr = array_unique($arr_column);
        }
        $statuses = ConfigStatus::whereIn('slug', ['pending', 'processing', 'in-transit', 'in-transit-to-be-delivered', 'delivered'])->orderBy('id', 'ASC')->get();
        $onlineTracking = null;
        $lastIndex = '';
        $statusValue = '';
        $onlineStatusesExceptions = [
            ['status' => 'AttemptFail', 'message' => 'Carrier attempted to deliver but failed, and usually leaves a notice and will try to deliver again.'],
            ['status' => 'Exception', 'message' => 'Custom hold, undelivered, returned shipment to sender or any shipping exceptions.'],
            ['status' => 'Expired', 'message' => 'Shipment has no tracking information for 30 days since added.'],
        ];
        $onlineStatuses = [
            ['value' => 1, 'status' => 'Pending', 'message' => 'New shipments added that are pending to track, or new shipments without tracking information available yet.'],
            ['value' => 2, 'status' => 'InfoReceived', 'message' => 'Carrier has received request from shipper and is about to pick up the shipment.'],
            ['value' => 3, 'status' => 'InTransit', 'message' => 'Carrier has accepted or picked up shipment from shipper. The shipment is on the way.'],
            ['value' => 4, 'status' => 'OutForDelivery', 'message' => 'Carrier is about to deliver the shipment , or it is ready to pickup.'],
            ['value' => 5, 'status' => 'Delivered', 'message' => 'The shipment was delivered successfully.'],
            // ['status' =>'AvailableForPickup', 'message' => 'The package arrived at a pickup point near you and is available for pickup.'],
        ];



        $aftershipStatus = general_setting('aftership')->status;

        if ($aftershipStatus == 'on') {
            $onlineTracking = $this->aftershipService->viewLabel($parcel->externalShipper->slug, $parcel->external_tracking);
            // dd($onlineTracking);
            $lastIndex = count($onlineTracking['data']['checkpoints']) - 1;

            foreach ($onlineStatuses as $key => $value) {
                if ($value['status'] == $onlineTracking['data']['tag']) {
                    $statusValue = $value['value'];
                }
            }
        }
        return view('admin.parcel.tracking', compact('onlineTracking', 'lastIndex', 'onlineStatuses', 'onlineStatusesExceptions', 'statusValue', 'parcel', 'statuses', 'externalTrackingStatusArr', 'deliveryStatus'));
    }

    public function addRecieverAddress(AddRecieverRequest $request)
    {

        $user = User::where('id', $request->reciever_user_id)->first();

        $shipping = new ShippingAddress();

        $shipping->country_id = $request->country_id;

        $shipping->first_name = $request->first_name;

        $shipping->last_name = $request->last_name;

        $shipping->email = $request->email;

        $shipping->initial_country = $request->initial_country;

        $shipping->country_code = $request->country_code;

        $shipping->phone = $request->phone;

        $shipping->state = $request->state;

        $shipping->city = $request->city;

        $shipping->zipcode = $request->zipcode;

        $shipping->crib = $request->crib;

        $shipping->address = $request->address;

        $shipping->status = 0;

        $shipping->morphable()->associate($user);

        $shipping->save();

        $notify = [
            'success' => "Reciever address has been added.",
            'value' => $shipping
        ];

        return $notify;
    }

    public function addSenderAddress(StoreRequest $request)
    {

        $user = Auth::guard('admin')->user();

        $shipping = new ShippingAddress();

        $shipping->country_id = $request->country_id;

        $shipping->first_name = $request->first_name;

        $shipping->last_name = $request->last_name;

        $shipping->email = $request->email;

        $shipping->initial_country = $request->initial_country;

        $shipping->country_code = $request->country_code;

        $shipping->phone = $request->phone;

        $shipping->state = $request->state;

        $shipping->city = $request->city;

        $shipping->zipcode = $request->zipcode;

        $shipping->address = $request->address;

        $shipping->status = 0;

        $shipping->morphable()->associate($user);

        $shipping->save();

        $notify = [
            'success' => "Sender address has been added.",
            'value' => $shipping
        ];

        return $notify;
    }

    public function getPickupStation(Request $request)
    {
        $parcel = '';

        if ($request->tracking) {

            $parcel = Parcel::where(['external_tracking' => $request->tracking])->first();
        }
        $pickupStation = PickupStation::get();
        if ($request->parcel_id) {
            $parcel = Parcel::findOrFail($request->parcel_id);
        }

        return view('admin.parcel.pickup-station', ['pickupStation' => $pickupStation, 'parcel' => $parcel]);
    }

    public function updateParcelStatus(Request $request)
    {


        if (count($request->parcelIds) > 0) {
            foreach ($request->parcelIds as $id) {
                $parcel = Parcel::findOrFail($id);
                $parcel->parcel_status_id = $request->parcelstatus_id;
                $parcel->save();

            }
            $notify = [
                'success' => "Parcel status has been updated",

            ];

            return $notify;
        }
    }
    public function recieveParcel($id)
    {

        $parcel = Parcel::findOrFail($id);
        $delivery = ParcelDelivery::where('parcel_id', $id)->orderBy('id', 'DESC')->first();
        $senderAddresses = Admin::select('id', 'first_name', 'last_name')->get();

        return view('admin.parcel.recieve-parcel', compact('parcel', 'delivery', 'senderAddresses'));
    }



    public function getOrderInvoice($id)
    {



        $payment = Parcel::select('id', 'payment_receipt')->where('id', $id)->first();


        return view('admin.parcel.order-invoice-receipt', ['payment' => $payment]);
    }

    public function data(Request $request)
    {

        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();

        $data = Parcel::whereNotIn('id', $ids)->where('parcel_status_id', '!=', 5);
        if ($request->title == 'All Parcels') {
            $data = $data->where('parcel_status_id', '!=', 1);
        }

        if (isset($request->user_id) && $request->user_id != '' && $request->user_id != null) {

            $data = $data->where(['user_id' => $request->user_id, 'drafted_at' => null]);
        }
        if (isset($request->status) && $request->status != '' && $request->status != null && $request->status != 'all') {

            $data = $data->where(['parcel_status_id' => $request->status, 'drafted_at' => null]);
        }
        if ((isset($request->status) && $request->status != '' && $request->status != null) || $request->status == 'all') {

            $data = $data->where('drafted_at', null);
        }
        if (isset($request->drafted) && $request->drafted != '' && $request->drafted != null && $request->drafted == 1) {

            $data = $data->whereNotNull('drafted_at');
        }

        $data = $data->orderBy('id', 'desc')->get();


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
                        <li><a class="dropdown-item parcel-data-view" href="' . route('parcel.show', ['id' => $row->id]) . '" data-parcel-id=' . $row->id . '>View</a></li>
                        <li><a class="dropdown-item parcel-data-edit" href="' . route('parcel.edit', ['id' => $row->id]) . '" data-parcel-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item ni-payment-show-order-modal" href="javascript:void(0)" data-parcel-id="' . $row->id . '">View Reciept</a></li>
                        <li><a class="dropdown-item parcel-data-invoice" href="' . route('parcel.invoice', ['id' => $row->id]) . '" target="_blank">Print Invoice</a></li>
                        <li><a class="dropdown-item parcel-data-invoice" href="' . route('parcel.invoice.label', ['id' => $row->id]) . '" target="_blank">Print Label</a></li>
                        <li><a class="dropdown-item ni-parcel-tracking" href="javascript:void(0)" data-parcel-id="' . $row->id . '">Tracking</a></li>

                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('image', function ($row) {
                if ($row->parcelImage->count() > 0) {
                    $html = '<img style="width:50px;" src="' . asset('storage/assets/parcel/' . $row->parcelImage[0]->hash_name) . '">';
                    return $html;
                } else {

                    $html = '<img style="width:50px;" src="' . asset('storage/assets/icons/default.png') . '">';
                    return $html;
                }

            })
            ->addColumn('checkbox', function ($row) {
                $html = '<input type="checkbox" name="parcelRows[]" class="parcel-checkbox" value="' . $row->id . '" data-parcel-id="' . $row->id . '" data-payment-status-id="' . $row->payment_status_id . '" />';
                return $html;
            })
            ->addColumn('status', function ($row) {
                $html = $row->parcelStatus->name;
                if (isset ($row->parcelStatus->color)) {
                    $html = '<span class="mb-1 badge" style="background-color:' . $row->parcelStatus->color . '">' . $row->parcelStatus->name . '</span>';
                }
                if ($row->parcelStatus->slug == 'in-transit-to-be-delivered') {
                    $html = '<a href="' . route('parcel.delivery.recieve', ['id' => $row->id]) . '" target="_blank"><span class="mb-1 badge" style="background-color:' . @$row->parcelStatus->color . '" >' . $row->parcelStatus->name . '</span></a>';
                }
                return $html;
            })
            ->addColumn('invoice_status', function ($row) {

                if ($row->show_invoice == 0) {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-danger ni-invoice-status" data-parcel-id="' . $row->id . '">Disabled</span></a>';
                } else {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-success ni-invoice-status" data-parcel-id="' . $row->id . '">Enabled</span></a>';
                }

                return $html;
            })

            ->addColumn('order_invoice_status', function ($row) {

                if ($row->payment_receipt != "" && Storage::disk('public')->exists('assets/payment/' . $row->payment_receipt)) {
                    $html = '<a data-invoice-id="' . $row->id . '" class="ni-payment-order-invoice" data-parcel-id="' . $row->id . '"><span class="' . $this->checkFileTypeByExtension($row->payment_receipt) . '"></span></a>';
                } else {
                    $html = '<a  data-invoice-id="' . $row->id . '"  class="open-modalfor-addrec"> Missing Receipt  </a>';
                    // $html = '<a href="' . route('user.parcel.invoice', ['id' => $row->id]). '"> View Invoice </a>mdi-file-pdf mdi-file-image';
    
                }
                return $html;
            })

            ->addColumn('payment', function ($row) {
                if ($row->paymentStatus->slug == 'paid' && $row->invoice_payment_receipt != null) {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-success" data-parcel-id="' . $row->id . '">' . $row->paymentStatus->name . '</span>&nbsp;<img class="ni-payment-show-modal" data-parcel-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                } elseif ($row->paymentStatus->slug == 'unpaid' && $row->invoice_payment_receipt != null) {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-danger" data-parcel-id="' . $row->id . '">Pending</span>&nbsp;<img class="ni-payment-show-modal" data-parcel-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                } elseif ($row->paymentStatus->slug == 'reject') {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-danger" data-parcel-id="' . $row->id . '">Reject</span>&nbsp;<img class="ni-payment-show-modal" data-parcel-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                } else {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-danger" data-parcel-id="' . $row->id . '">Unpaid</span>&nbsp;<img class="ni-payment-show-modal" data-parcel-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                }
                return $html;
            })
            ->addColumn('amount', function ($row) {
                $total = $this->getShippingCalculator($row->branch_id, $row->freight_type, $row->import_duty_id, $row->ob_fees, $row->length, $row->width, $row->height, $row->weight, $row->item_value, $row->discount, $row->delivery_fees, $row->tax)['total'];

                //return (isset($total) ? 'ƒ '.number_format($total, 2).' ANG' : 'ƒ 0.00 ANG');
                return (isset ($row->amount_total) ? 'ƒ ' . number_format($row->amount_total, 2) . ' ANG' : 'ƒ 0.00 ANG');

            })
            ->addColumn('description', function ($row) {
                return (isset ($row->product_description) ? $row->product_description : 'N/A');
            })
            ->addColumn('destination', function ($row) {
                return (isset ($row->reciever->address) ? $row->reciever->address : 'N/A');
            })
            ->addColumn('sender', function ($row) {
                return (isset ($row->sender) ? ucwords($row->sender->first_name . ' ' . $row->sender->last_name) : 'N/A');
            })
            ->addColumn('origin', function ($row) {
                return (isset ($row->sender->country) ? ucwords($row->sender->country->name) : 'N/A');
            })
            ->addColumn('reciever', function ($row) {
                return (isset ($row->full_name) ? $row->full_name : 'N/A');
            })
            ->addColumn('invoice', function ($row) {
                return (isset ($row->invoice_no) ? '<a  href="' . route('parcel.show', ['id' => $row->id]) . '">' . $row->invoice_no . '</a>' : 'N/A');
            })
            ->rawColumns(['action', 'image', 'created_at', 'status', 'invoice_status', 'order_invoice_status', 'payment', 'amount', 'description', 'destination', 'reciever', 'sender', 'origin', 'invoice', 'checkbox'])
            ->make(true);
    }

    public function approvedPayment($id)
    {
        $payment = Parcel::with('paymentStatus')->findOrFail($id);

        $payment->payment_status_id = 1;

        $payment->save();

        $notify = ['success' => "Payment has been approved."];

        return $notify;
    }

    function checkFileTypeByExtension($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif']; // Add more image extensions if needed
        $pdfExtension = 'pdf';

        if (in_array(strtolower($extension), $allowedImageExtensions)) {
            // File is an image
            return 'mdi mdi-file-image';
        } elseif (strtolower($extension) === $pdfExtension) {
            // File is a PDF
            return 'mdi mdi-file-pdf ';
        } else {
            // File type is not supported
            return 'mdi mdi-file-image';
        }

    }

    public function updateDeliveryDate(Request $request)
    {
        if ($request->eventType == 'parcel') {

            $id = str_replace('p-', '', $request->id);
            $parcel = Parcel::findOrFail($id);
            $parcel->es_delivery_date = $request->droppedDate;
            $parcel->save();
        }

        $notify = ['success' => "Parcel delivery date updated successfully"];

        return $notify;
    }

    public function updatePaymentStatus(Request $request)
    {


        $payment = Parcel::with('paymentStatus')->findOrFail($request->id);

        $payment->payment_status_id = $request->payment_status;

        if ($request->payment_method)
            $payment->payment_id = $request->payment_method;

        if ($request->payment_receipt) {

            $payment->invoice_payment_receipt = $this->fileUpload($request->payment_receipt, $payment->invoice_payment_receipt);
        }

        $payment->save();

        $payment->load('paymentStatus');

        $admin = Admin::first();

        $user = User::findOrFail($payment->user_id);

        $template = EmailTemplate::where('slug', 'parcel-payment-status')->first();

        if ($template) {

            $shortCodes = [
                'tracking_no' => $payment->external_tracking,
                'delivery_time' => $payment->es_delivery_date,
                'invoice_url' => route('parcel.invoice', ['id' => $payment->id]),
            ];

            //Send notification to user
            event(new ParcelEvent($template, $shortCodes, $payment, $admin, 'ParcelPaymentStatus'));

            //Send notification to user
            event(new ParcelEvent($template, $shortCodes, $payment, $user, 'ParcelPaymentStatus'));
        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
        }

        $notify = ['success' => "Payment status updated."];

        return $notify;
    }

    public function changeInvoiceStatus($id)
    {
        $payment = Parcel::findOrFail($id);

        if ($payment->show_invoice == 0) {

            $payment->show_invoice = 1;
        } else {

            $payment->show_invoice = 0;
        }

        $payment->save();

        $notify = ['success' => "Invoice status has been changed."];

        return $notify;
    }

    public function archivedParcels(Request $request)
    {
        $title = 'Archived';

        if ($request->ajax()) {
            $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();

            if (isset($request->user_id) && $request->user_id != '' && $request->user_id != null) {

                $data = Parcel::whereNotIn('id', $ids)->where(['user_id' => $request->user_id, 'payment_status_id' => 2, 'parcel_status_id' => 5])->get();
            } else {

                $data = Parcel::whereNotIn('id', $ids)->where(['parcel_status_id' => 5])->get();

            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('checkbox', function ($row) {
                    $html = '<input type="checkbox" name="parcelRows[]" class="parcel-checkbox" data-parcel-id="' . $row->id . '" data-payment-status-id="' . $row->payment_status_id . '" />';
                    return $html;
                })
                ->addColumn('status', function ($row) {
                    $html = $row->parcelStatus->name;
                    if (isset ($row->parcelStatus->color)) {
                        $html = '<span class="mb-1 badge" style="background-color:' . $row->parcelStatus->color . '">' . $row->parcelStatus->name . '</span>';
                    }
                    if ($row->parcelStatus->slug == 'in-transit-to-be-delivered') {
                        $html = '<a href="' . route('parcel.delivery.recieve', ['id' => $row->id]) . '" target="_blank"><span class="mb-1 badge" style="background-color:' . @$row->parcelStatus->color . '" >' . $row->parcelStatus->name . '</span></a>';
                    }
                    return $html;
                })
                ->addColumn('invoice_status', function ($row) {

                    if ($row->show_invoice == 0) {
                        $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-danger">Disabled</span></a>';
                    } else {
                        $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-success">Enabled</span></a>';
                    }

                    return $html;
                })
                ->addColumn('payment', function ($row) {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-success">Paid</span>&nbsp;<img class="" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                    return $html;
                })
                ->addColumn('amount', function ($row) {
                    $total = $this->getShippingCalculator($row->branch_id, $row->freight_type, $row->import_duty_id, $row->ob_fees, $row->length, $row->width, $row->height, $row->weight, $row->item_value, $row->discount, $row->delivery_fees, $row->tax)['total'];

                    return (isset ($total) ? number_format($total, 2) : '0.00');
                })
                ->addColumn('description', function ($row) {
                    return (isset ($row->product_description) ? $row->product_description : 'N/A');
                })
                ->addColumn('destination', function ($row) {
                    return (isset ($row->reciever->address) ? $row->reciever->address : 'N/A');
                })
                ->addColumn('reciever', function ($row) {
                    return (isset ($row->full_name) ? $row->full_name : 'N/A');
                })
                ->addColumn('invoice', function ($row) {

                    return (isset ($row->invoice_no) ? '<a  href="' . route('parcel.show', ['id' => $row->id]) . '" target="_blank">' . $row->invoice_no . '</a>' : 'N/A');
                    // return (isset($row->invoice_no) ? $row->invoice_no : 'N/A');
                })
                ->rawColumns(['created_at', 'status', 'invoice_status', 'payment', 'amount', 'description', 'destination', 'reciever', 'invoice', 'checkbox'])
                ->make(true);
        }

        return view('admin.parcel.archived', compact('title'));

    }

    public function print($id)
    {
        // Retrieve the invoice by ID from the database
        $invoice = Parcel::findOrFail($id);

        // You can customize the PDF generation process based on your requirements
        $pdf = App::make('dompdf.wrapper');

        // Load the view file and render it
        $pdf->loadView('admin.parcel.invoice-print', compact('invoice'));

        $pdf->render();

        // Generate a file path to save the PDF
        $directory = storage_path('app/public/assets/invoices/');

        $no = rand(10, 100);

        if (!File::isDirectory($directory)) {

            File::makeDirectory($directory, 0777, true, true);
        }

        $filePath = $directory . $no . $invoice->id . '.pdf';

        // Save the PDF to the specified file path
        file_put_contents($filePath, $pdf->output());

        // Redirect the user to download the PDF
        return response()->download($filePath);
    }

    public function invoicePrint($id)
    {
        // Retrieve the invoice by ID from the database
        $invoice = Parcel::findOrFail($id);
        // Generate a barcode 
        $barcode = $this->generateQRcode(route('parcel.invoice', ['id' => $invoice->id]));

        $total = $this->getShippingCalculator($invoice->branch_id, $invoice->freight_type, $invoice->import_duty_id, $invoice->ob_fees, $invoice->length, $invoice->width, $invoice->height, $invoice->weight, $invoice->item_value, $invoice->discount, $invoice->delivery_fees, $invoice->tax);

        return view('admin.parcel.invoice-print', compact('invoice', 'total', 'barcode'));
    }

    public function invoiceLabel($id)
    {
        // Retrieve the invoice by ID from the database
        $invoice = Parcel::findOrFail($id);
        // Generate a barcode
        $QRcode = $this->generateQRcode($invoice->waybill);

        // $barcode = $this->generateBarcode($invoice->waybill,'UPC-A');  
        $barcode = '';

        $total = $this->getShippingCalculator($invoice->branch_id, $invoice->freight_type, $invoice->import_duty_id, $invoice->ob_fees, $invoice->length, $invoice->width, $invoice->height, $invoice->weight, $invoice->item_value, $invoice->discount, $invoice->delivery_fees, $invoice->tax);

        return view('admin.parcel.invoice-label', compact('invoice', 'total', 'barcode', 'QRcode'));
    }

    public function imagesGet($id)
    {

        $images = ParcelImage::where('parcel_id', $id)->get();

        return view('admin.parcel.images', compact('images'));
    }

    public function generateBarcode($barcode, $barcodeType)
    {
        // $barcode = '123456789012'; // Data to encode in the barcode
        // $barcodeType = 'EAN-13'; // Barcode type (e.g., 'EAN-13', 'CODE-128', 'UPC-A')

        $generator = new DNS1D();

        $barcodeData = $generator->getBarcodeHTML($barcode, $barcodeType);

        return $barcodeData;
    }

    public function generateQRcode($data = null, $barcodeType = null)
    {

        $QRData = QrCode::generate($data);
        ;

        return $QRData;
    }

    public function saveParcelSignature(Request $request)
    {
        $signatureData = $request->signature;
        $imageName = 'signature_' . time() . '.png';
        $directory = storage_path('app/public/assets/signatures/');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        $imagePath = $directory . $imageName;

        file_put_contents($imagePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData)));

        $notify = [
            'success' => "Signature saved successfully",
            'imageName' => $imageName
        ];

        return $notify;
    }

    public function shipmentDelivery(UpdateDeliveryRequest $request, string $id)
    {
        $delivery = ParcelDelivery::where('parcel_id', $id)->orderBy('id', 'DESC')->first();
        if ($delivery) {
            if (isset($request->parcel_image)) {
                $file = $request->parcel_image;
                if (Storage::exists('assets/parcelDelivery/' . $delivery->parcel_image)) {

                    Storage::Delete('assets/parcelDelivery/' . $delivery->parcel_image);

                    $file->storeAs('assets/parcelDelivery/', $file->hashName());
                } else {
                    $file->storeAs('assets/parcelDelivery/', $file->hashName());
                }

                $delivery->parcel_image = $file->hashName();
            }

            // $delivery->payment_id = $request->payment_method_id;
            $delivery->admin_id = $request->delivered_by;
            $delivery->reciever_name = $request->reciever_name;
            $delivery->delivery_date = $request->delivery_date;
            $delivery->signature = $request->sign_image;
            $delivery->save();
        } else {
            $delivery = new ParcelDelivery();
            if (isset($request->parcel_image)) {
                $file = $request->parcel_image;
                if (Storage::exists('assets/parcelDelivery/' . $delivery->parcel_image)) {

                    Storage::Delete('assets/parcelDelivery/' . $delivery->parcel_image);

                    $file->storeAs('assets/parcelDelivery/', $file->hashName());
                } else {
                    $file->storeAs('assets/parcelDelivery/', $file->hashName());
                }

                $delivery->parcel_image = $file->hashName();
            }
            $delivery->parcel_id = $id;
            $delivery->admin_id = $request->delivered_by;
            $delivery->reciever_name = $request->reciever_name;
            $delivery->delivery_date = $request->delivery_date;
            $delivery->signature = $request->sign_image;
            $delivery->save();
        }

        $deliverStatus = ConfigStatus::where('slug', 'delivered')->pluck('id')->first();
        if ($deliverStatus) {
            $parcel = Parcel::findOrFail($id);
            $parcel->parcel_status_id = $deliverStatus;
            $parcel->save();
        }

        $notify = [
            'success' => "Shipment Delivered successfully.",
            'redirect' => route('parcel.show', ['id' => $id]),
        ];
        return $notify;
    }

    public function getOnlineTracking(Request $request)
    {
    }
}
