<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Models\Admin;

use Carbon\Carbon;

use App\Models\Parcel;

use App\Models\Wallet;

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

use App\Models\ShippingAddress;

use App\Services\AftershipService;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\App;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\User\Parcel\CreateRequest;
use App\Http\Requests\User\Parcel\UpdateRequest;
use App\Notifications\ShipmentCreateNotification;
use App\Http\Requests\User\ShipperAddress\StoreRequest;

class ParcelController extends Controller
{
    use AirCalculator, SeaCalculator;

    private $aftershipService;

    public function __construct(AftershipService $aftershipService)
    {
        $this->aftershipService = $aftershipService;
    }

    public function index()
    {
        
        $config = 'all';
        $drafted = null;
        $title = 'All Parcels';

        return view('user.parcel.index', ['status' => $config, 'drafted' => $drafted, 'title' => $title]);
    }

    public function pendingParcels()
    {
        $config = ConfigStatus::where('name', 'pending')->orWhere('name', 'Pending')->first()->id;

        $title = 'Pending Parcels';
        return view('user.parcel.index', ['status' => $config, 'drafted' => null, 'title' => $title]);
    }

    public function addReceipt(Request $request){
        $parcel = Parcel::findOrFail($request->parchase_id);
        $parcel->show_invoice = 1;
       
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
        $shipmentAddress = ShippingAddress::whereHasMorph('morphable', [Admin::class])->get();
        $reciver = ShippingAddress::whereHasMorph('morphable', [User::class])
            ->where('morphable_id', Auth::guard('web')->user()->id)->pluck('address', 'id')->toArray();
          
        $paymentStatuses = PaymentStatus::get();
        return view('user.parcel.add', compact('shipmentAddress', 'reciver', 'paymentStatuses'));
    }
   

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $parcel = Parcel::findOrFail($id);

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

        if($aftershipStatus == 'on'){
            $onlineTracking =  $this->aftershipService->viewLabel($parcel->externalShipper->slug, $parcel->external_tracking);
            // dd($onlineTracking);
            $lastIndex = count($onlineTracking['data']['checkpoints']) - 1;
            
            foreach ($onlineStatuses as $key => $value) {
                if ($value['status'] == $onlineTracking['data']['tag']) {
                    $statusValue = $value['value'];
                }
            }
        }

        return view('user.parcel.show', compact('onlineTracking', 'lastIndex', 'onlineStatuses', 'onlineStatusesExceptions', 'statusValue', 'parcel', 'statuses'));
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

        return  view('user.parcel.calculator', compact('total', 'totalConverted', 'parcels'))->render();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
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
        $user = Auth::user();
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

        $parcels->user_id = Auth::user()->id;

        $parcels->full_name = $request->full_name;

        $parcels->external_waybill = $request->external_awb;

        $parcels->reciever_address_id = $request->reciver_ship_address;

        $parcels->sender_address_id = $request->sender_ship_address;

        $parcels->branch_id = $this->branch =  $request->branch_id;

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

        $parcels->length = $this->length =  (isset($request->length_inch) ? $request->length_inch : 0);

        $parcels->width =  $this->width = (isset($request->width_inch) ? $request->width_inch : 0);

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


        $parcels->parcel_status_id = 1;

        $parcels->external_tracking = $request->external_tracking;

        $parcels->es_delivery_date = $request->estimate_delivery_date;

        $parcels->payment_id = $request->payment_method;

        $parcels->payment_status_id = 1;

        $parcels->payment_receipt = $this->fileUpload($request->payment_file);

        $parcels->comment = $request->comment;

        $parcels->amount_total =  $total['total'];

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
        //Send notification to user
        event(new ParcelEvent($parcels, $admin, 'CreateParcel'));

        $user = User::findOrFail($parcels->user_id);
        //Send notification to user
        event(new ParcelEvent($parcels, $user, 'CreateParcel'));

        $template = EmailTemplate::where('slug', 'new-shipment')->first();

        if ($template) {

            $notification = new ShipmentCreateNotification(
                $template,
                [
                    'tracking_no' => $parcels->external_tracking,
                    'delivery_time' =>  $parcels->es_delivery_date,
                    'invoice_url' => route('parcel.invoice', ['id' => $parcels->id]),
                ]
            );

            $user->notify($notification);
        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];

            // return $notify;
        }


        $notify = [
            'success' => "Parcel has been Added.",
            'redirect' => route('user.parcel.index'),
            'id' => $parcels->id,
        ];

        return $notify;
    }

    public function parcelData(Request $request)
    {

        $parcel =  Parcel::where('external_tracking', $request->tracking)->first();

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

    public function fileStore(Request $request)
    {
        $this->fileUploadMultiple($request->file, $request->parcel_id);
    }

    public function afterShipInfo($parcels)
    {
        $deliveryDate = date('Y-m-d', strtotime($parcels->es_delivery_date));

        $phone = '+' . $parcels->reciever->country_code . $parcels->reciever->phone;
        return  [
            'tracking_number' =>  $parcels->external_tracking,
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
            "note" =>  $parcels->comment,
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
            return ($total - $discount) + $shipping + $tax;
        } else {
            $total = $total + $shipping + $tax;
            $discount = ($total * $discount) / 100; //discount is always calculated in percentage
            return ($total - $discount);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $shipmentAddress = ShippingAddress::whereHasMorph('morphable', [Admin::class])->get();

        $parcels = Parcel::findOrFail($id);

        $shipmentAddressRecive = ShippingAddress::whereHasMorph('morphable', [User::class])
            ->where('morphable_id', Auth::user()->id)->get();
        return view('user.parcel.edit', compact('parcels', 'shipmentAddress', 'shipmentAddressRecive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {

        $parcels = Parcel::with('parcelStatus')->findOrFail($id);

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

        $parcels->shipment_mode_id = $request->shipment_mode;

        $parcels->import_duty_id = $request->import_duties;

        $parcels->product_description = $request->product_desc;

        if (isset($request->parcel_status) && $parcels->parcel_status_id != $request->parcel_status) {

            $parcels->parcel_status_id = $request->parcel_status;

            $statusFlag = 1;
        } else {
            $statusFlag = 0;
        }

        $parcels->external_tracking = $request->external_tracking;

        $parcels->es_delivery_date = $request->estimate_delivery_date;

        $parcels->comment = $request->comment;

        $parcels->quantity = (isset($request->quantity) ? $request->quantity : 0);

        $parcels->weight = $this->weight = (isset($request->weight) ? $request->weight : 0);

        $parcels->length = $this->length =  (isset($request->length_inch) ? $request->length_inch : 0);

        $parcels->width =  $this->width = (isset($request->width_inch) ? $request->width_inch : 0);

        $parcels->height = $this->height = (isset($request->height_inch) ? $request->height_inch : 0);

        $parcels->dimension = (isset($request->dimention) ? $request->dimention : 0);

        $parcels->delivery_method = $request->delivery_method;

        if ($request->delivery_method > 0) {

            $parcels->pickup_station_id = $request->pickup_station;
        }
        $parcels->delivery_fee = (isset($request->delivery_fees) ? $request->delivery_fees : 0);

        $parcels->discount = (isset($request->discount) ? $request->discount : 0);

        $parcels->item_value = (isset($request->item_value) ? $request->item_value : 0);

        $parcels->ob_fees = (isset($request->ob_fees) ? $request->ob_fees : 1);

        $parcels->tax = (isset($request->tax) ? $request->tax : 0);

        $parcels->save();

        $parcels->load('parcelStatus');

        if (isset($request->parcel_status) && $statusFlag == 1) {

            $admin = Admin::first();
            //Send notification to user
            event(new ParcelEvent($parcels, $admin, 'ParcelStatus'));

            $user = User::findOrFail($parcels->user_id);
            //Send notification to user
            event(new ParcelEvent($parcels, $user, 'ParcelStatus'));
        }

        $admin = Admin::first();
        //Send notification to user
        event(new ParcelEvent($parcels, $admin, 'UpdateParcel'));

        $user = User::findOrFail($parcels->user_id);
        //Send notification to user
        event(new ParcelEvent($parcels, $user, 'UpdateParcel'));

        $notify = [
            'success' => "Parcel has been Updated.",
            'redirect' => route('user.parcel.index'),
            'id' => $parcels->id,
        ];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Parcel::findOrFail($id)->delete();

        $notify = ['success' => "Shipment Type has been deleted."];

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

        $users = User::select('first_name', 'last_name', 'customer_no', 'email', 'id')->where('status', 1)->where(function ($query) use ($q) {
            $query->where('first_name', 'LIKE', '%' . $q . '%')
                ->orWhere('last_name', 'LIKE', '%' . $q . '%')
                ->orWhere('customer_no', 'LIKE', '%' . $q . '%')
                ->orWhere('email', 'LIKE', '%' . $q . '%');
        })->get();

        if (count($users) > 0) {

            foreach ($users as  $user) {

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

        $address = ShippingAddress::select('id', 'name')->whereHasMorph('morphable', [User::class])
            ->where('morphable_id', $request->id);

        if (isset($address)) {

            if ($address->count() == 0) {

                $arr  =  [
                    'error' => "Sorry, there is no address found for this user. Click Add Reciver Address to add address for user.",
                    'full_name' => $user->first_name . ' ' . $user->last_name,
                    'addresses' =>  $address->get(),
                ];
            } else {

                $arr =  [
                    'error' => null,
                    'full_name' => $user->first_name . ' ' . $user->last_name,
                    'addresses' =>  $address->get(),
                ];
            }
        }
        return  $arr;
    }

    public function getRecieverhtml()
    {

        return view('user.parcel.reciever');
    }

    public function getPaymentHtml($id)
    {
        
        $payment = Parcel::select('id', 'payment_receipt')->where('id', $id)->first();
        return view('user.parcel.payment', ['payment' => $payment]);
    }

    public function getParcelTracking($id)
    {
        $parcel = Parcel::findOrFail($id);
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

        if($aftershipStatus == 'on'){
            $onlineTracking =  $this->aftershipService->viewLabel($parcel->externalShipper->slug, $parcel->external_tracking);
            // dd($onlineTracking);
            $lastIndex = count($onlineTracking['data']['checkpoints']) - 1;
            
            foreach ($onlineStatuses as $key => $value) {
                if ($value['status'] == $onlineTracking['data']['tag']) {
                    $statusValue = $value['value'];
                }
            }
        }

        return view('user.parcel.tracking', compact('onlineTracking', 'lastIndex', 'onlineStatuses', 'onlineStatusesExceptions', 'statusValue', 'parcel', 'statuses'));
    }

    public function addRecieverAddress(StoreRequest $request)
    {
      
        $user = User::where('id', Auth::guard("web")->user()->id)->first();

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
       
        if (Auth::guard('web')->user()->alert == 0) {
            User::where('id', Auth::guard('web')->user()->id)->update(['alert' => 1]);
        }


        $notify = [
            'success' => "Reciever address has been added.",
            'value' => $shipping
        ];

        return $notify;
    }

    public function getPickupStation()
    {

        $pickupStation = PickupStation::get();

        return view('user.parcel.pickup-station', ['pickupStation' => $pickupStation]);
    }

    public function draftedParcels()
    {
        $drafted = 1;
        $title = 'Drafted Parcels';
        return view('user.parcel.index', ['status' => null, 'drafted' => $drafted, 'title' => $title]);
    }

    function toDraft(Request $request)
    {

        foreach ($request->arr as $arr) {
            $parcel =  Parcel::findOrFail($arr);
            $parcel->drafted_at = Carbon::now()->format('Y-m-d H:i:s');
            $parcel->save();
        }

        $notify = ['success' => "Parcel has been drafted."];

        return $notify;
    }

    public function data(Request $request)
    {
        
     
         
        // dd($request->title);  ' All Parcels'

        // $title = 'Pending Parcels';
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();

        $data = Parcel::where('user_id', Auth::user()->id);
       
        if($request->title=='All Parcels'){
            $data->where('parcel_status_id','!=',1);
        }elseif($request->title=='Pending Parcels'){
            $data->where('parcel_status_id','=',1);
        }else{
            $data->where('parcel_status_id','!=',5);
        }
       $data= $data->whereNotIn('id', $ids);

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
                $action = '<li><a class="dropdown-item parcel-data-view" href="' . route('user.parcel.show', ['id' => $row->id]) . '" data-parcel-id=' . $row->id . '>View</a></li> 
                <li><a class="dropdown-item ni-parcel-tracking" href="javascript:void(0)" data-parcel-id="' . $row->id . '">Tracking</a></li>';
                if ($row->show_invoice == 1) {
                    $action .= ' <li><a class="dropdown-item parcel-data-invoice" href="' . route('user.parcel.invoice', ['id' => $row->id]) . '" target="_blank">Print Invoice</a></li>';
                }
                $actionBtn = '<div class="dropdown dropstart">
                    <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-sm">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>print
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin: 0px;"> 
                    ' . $action . ' 
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('checkbox', function ($row) {
                $html = '<input type="checkbox" name="parcelRows[]" class="parcel-checkbox" data-parcel-id="' . $row->id . '" data-payment-status-id="' . $row->payment_status_id . '" />';
                return $html;
            })
            ->addColumn('status', function ($row) {
                $html = $row->parcelStatus->name;
                if (isset($row->parcelStatus->color)) {
                    $html = '<span class="mb-1 badge" style="background-color:' . $row->parcelStatus->color . '">' . $row->parcelStatus->name . '</span>';
                }
                return $html;
            })
            ->addColumn('invoice_status', function ($row) {
                
                if ($row->show_invoice == 0 && $row->parcel_status_id == 1) {
                    $html = '<a  data-invoice-id="' . $row->id . '"  class="open-modalfor-addrec"> Missing Invoice </a>';
                } else {
                    $html = '<a data-invoice-id="' . $row->id . '" class="ni-payment-show-modal" data-parcel-id="' . $row->id . '"><span class="mdi mdi-file-document-box"></span></a>';
                }
                return $html;
            })
            ->addColumn('payment', function ($row) {
                if ($row->paymentStatus->slug == 'paid') {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-success" data-parcel-id="' . $row->id . '">' . $row->paymentStatus->name . '</span>&nbsp;<img class="ni-payment-show-modal" data-parcel-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                } else {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-danger" data-parcel-id="' . $row->id . '">Unpaid</span>&nbsp;<img class="ni-payment-show-modal" data-parcel-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                }
                return $html;
            })
            ->addColumn('amount', function ($row) {
                // if ($row->show_invoice == 0) {
                //     $html = 'N/A';
                // } else {
                    $total = $this->getShippingCalculator($row->branch_id, $row->freight_type, $row->import_duty_id, $row->ob_fees, $row->length, $row->width, $row->height, $row->weight, $row->item_value, $row->discount, $row->delivery_fees, $row->tax)['total'];
                    $html = (isset($total) ? 'ƒ '.number_format($total, 2).' ANG' : 'ƒ 0.00 ANG');
                // }
                return $html;
            })
            ->addColumn('description', function ($row) {
                return (isset($row->product_description) ? $row->product_description : 'N/A');
            })
            ->addColumn('destination', function ($row) {
                return (isset($row->sender->address) ? $row->sender->address : 'N/A');
            })
            ->addColumn('sender', function ($row) {
                return (isset($row->sender) ? ucwords($row->sender->first_name. ' '. $row->sender->last_name) : 'N/A');
            })
            ->addColumn('origin', function ($row) {
                return (isset($row->sender->country) ? ucwords($row->sender->country->name) : 'N/A');
            })
            ->addColumn('reciever', function ($row) {
                return (isset($row->full_name) ? $row->full_name : 'N/A');
            })
            ->addColumn('invoice', function ($row) {
                return (isset($row->invoice_no) ? $row->invoice_no : 'N/A');
            })
            ->rawColumns(['action', 'checkbox', 'created_at', 'status', 'invoice_status', 'payment', 'amount', 'description', 'destination', 'reciever','origin','sender', 'invoice'])
            ->make(true);
    }

    public function archivedParcels(Request $request)
    {
        $title = 'Archived';

        if ($request->ajax()) {
            $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();

            $data = Parcel::whereNotIn('id', $ids)->where(['user_id' => Auth::user()->id,'payment_status_id' => 2,'parcel_status_id' => 5])->get();
            


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
                    if (isset($row->parcelStatus->color)) {
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

                    return (isset($total) ? number_format($total, 2) : '0.00');
                })
                ->addColumn('description', function ($row) {
                    return (isset($row->product_description) ? $row->product_description : 'N/A');
                })
                ->addColumn('destination', function ($row) {
                    return (isset($row->reciever->address) ? $row->reciever->address : 'N/A');
                })
                ->addColumn('reciever', function ($row) {
                    return (isset($row->full_name) ? $row->full_name : 'N/A');
                })
                ->addColumn('invoice', function ($row) {
                    return (isset($row->invoice_no) ? $row->invoice_no : 'N/A');
                })
                ->rawColumns(['created_at', 'status', 'invoice_status', 'payment', 'amount', 'description', 'destination', 'reciever', 'invoice', 'checkbox'])
                ->make(true);
        }
        
        return view('user.parcel.archived',compact('title'));
        
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

    public function print($id)
    {
        // Retrieve the invoice by ID from the database
        $invoice = Parcel::findOrFail($id);

        // You can customize the PDF generation process based on your requirements
        $pdf = App::make('dompdf.wrapper');

        // Load the view file and render it
        $pdf->loadView('user.parcel.invoice-print', compact('invoice'));

        $pdf->render();

        // Generate a file path to save the PDF
        $directory = storage_path('app/public/assets/invoices/');

        $no =  rand(10, 100);

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
        $barcode = $this->generateQRcode(route('user.parcel.invoice', ['id' => $invoice->id]));

        $total = $this->getShippingCalculator($invoice->branch_id, $invoice->freight_type, $invoice->import_duty_id, $invoice->ob_fees, $invoice->length, $invoice->width, $invoice->height, $invoice->weight, $invoice->item_value, $invoice->discount, $invoice->delivery_fees, $invoice->tax);

        return view('user.parcel.invoice-print', compact('invoice', 'total', 'barcode'));
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

        return view('user.parcel.invoice-label', compact('invoice', 'total', 'barcode', 'QRcode'));
    }

    public function imagesGet($id)
    {

        $images = ParcelImage::where('parcel_id', $id)->get();

        return view('user.parcel.images', compact('images'));
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

        $QRData = QrCode::generate($data);;

        return $QRData;
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
}
