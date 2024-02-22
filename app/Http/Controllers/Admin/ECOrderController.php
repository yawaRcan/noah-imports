<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Parcel;
use App\Models\Wallet;
use App\Models\Payment;
use App\Models\Product;
use App\Events\ParcelEvent;
use App\Models\ConfigStatus;
use Illuminate\Http\Request;
use App\Models\EcommerceCart;
use App\Models\EmailTemplate;
use App\Models\PaymentStatus;
use App\Models\EcommerceOrder;
use App\Traits\CartCalculation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Notifications\ShipmentCreateNotification;
use App\Http\Requests\Admin\EcommerceOrder\StoreOrderRequest;

class ECOrderController extends Controller
{
    use CartCalculation;
    
    protected $product = null;

    protected $user_id = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index($status = null)
    {
        return view('admin.ecommerce.order.index',compact('status'));
    }

    public function store(Request $request)
    {
        $paymentStatuses = PaymentStatus::all();
        $paymentMethod = Payment::findOrFail($request->payment_method_id);
        $user = User::findOrFail($request->user_id);
        $paymentStatusId = $paymentStatuses->where('slug', 'unpaid')->pluck('id')->first();
        if ($paymentMethod->slug == "account-funds") {
            $userBalance = $user->balance();
            $amount = (float) str_replace(',', '', $request->total_converted);

            if ($userBalance < 0 || $userBalance < $amount) {
                $notify = ['error' => "Your Account Balance is not enough!"];
                return $notify;
            }
        }
        // $pendingStatus = ConfigStatus::where('name', 'pending')->orWhere('name', 'Pending')->first();
        // if ($pendingStatus)
        //     $deliveryStatusId = $pendingStatus->id;
        // else
        //     $deliveryStatusId = null;

        $id = EcommerceOrder::orderBy('id', 'desc')->pluck('id')->first();
        if ($id)
            $id = $id + 1;
        else
            $id = 1;

        $quantity = EcommerceCart::where('user_id', $request->user_id)->whereNull('order_id')->sum('quantity');

        $order = new EcommerceOrder();
        $order->user_id = $request->user_id;
        $order->order_number = substr(str_shuffle(md5(rand(1000, 9999))), 0, 7);
        $order->shipping_id = $request->shipping_address_id;
        $order->payment_id = $request->payment_method_id;
        $order->payment_status_id = $paymentStatusId;
        $order->currency_id = $request->currency_id;
        $order->sub_total = str_replace(',', '', $request->subtotal);
        $order->total_amount = str_replace(',', '', $request->total);
        $order->total_converted = str_replace(',', '', $request->total_converted);
        $order->quantity = $quantity;
        $order->insurance_tax = (isset($request->eGaroshiTax) ? str_replace(',', '', $request->eGaroshiTax) : 0);;
        $order->discount = (isset($request->discount) ? $request->discount : 0);
        $order->shipping_price = (isset($request->shipping_price) ? $request->shipping_price : 0);
        $order->tax = (isset($request->tax) ? $request->tax : 0); 
        $order->invoice = general_setting('setting')->invoice_no . $id;
        $order->awb = general_setting('setting')->waybil_no . $id;
        $order->save();

        EcommerceCart::where('user_id', $request->user_id)->whereNull('order_id')->update(['order_id' => $order->id]);
 
        $redirect = route('ec-order.payment.add',['id' => $order->id]); 
        $notify = ['success' => "Order created successfully.", 'redirect' => $redirect];
        return $notify;
    }

    public function addPayment(string $id)
    {
        $order = EcommerceOrder::findOrFail($id);
        $paymentMethods = Payment::orderBy('name', 'ASC')->get();
        $recieverAddresses = $order->user->shipping;
        return view('admin.ecommerce.order.add_payment', compact('order', 'paymentMethods', 'recieverAddresses'));
    }

    public function getPaymentInfo(string $id, $user_id)
    {
        $user = User::findOrFail($user_id);
        $payment = Payment::findOrFail($id);
        if ($payment->slug == "account-funds") {
            $userBalance = $user->balance();
            if($userBalance < 0){
                $html = "<p><u>Account Info</u></p><p>Wallet Balance: <strong class='text-danger'>ƒ " . $userBalance . " ANG</strong></p><p>Sincerely,</p><p>Noah Imports Courier Team</p>";
            }
            else{
                $html = "<p><u>Account Info</u></p><p>Wallet Balance: <strong>ƒ " . $userBalance . " ANG</strong></p><p>Sincerely,</p><p>Noah Imports Courier Team</p>";
            }
            
            return $html;
        }
        return $payment->information;
    }

    public function updatePayment(Request $request, string $id)
    {
        $paymentStatusId = PaymentStatus::where('slug', 'paid')->pluck('id')->first();
        $paymentMethod = Payment::findOrFail($request->payment_method_id);
        $order = EcommerceOrder::findOrFail($id);
        $balanceFlag = 0;
        if ($paymentMethod->slug == "account-funds") {
            $userBalance = $order->user->balance();
            $amount = $order->total_converted;

            if ($userBalance < 0 || $userBalance < $amount) {
                $notify = ['error' => "Your Account Balance is not enough!"];
                return $notify;
            } else {
                $balanceFlag = 1;
            }
        }
        if (isset($request->payment_receipt)) {
            $order->payment_receipt = $this->fileUpload($request->payment_receipt, $order->payment_receipt);
        }
        $order->payment_id = $request->payment_method_id;
        $order->payment_status_id = $paymentStatusId;
        $order->shipping_id = $request->shipping_address_id;
        $order->save();

        if ($balanceFlag) {
            $wallet = new Wallet();
            $wallet->payment_id = $order->payment_id;
            $wallet->currency_id = $order->currency_id;
            $wallet->type = 'debit';
            $wallet->amount = $order->total_amount;
            $wallet->amount_converted = $order->total_converted;
            $wallet->description = 'Purchase Order Amount';
            $wallet->status = 'approved';
            $wallet->reason = 'Payment Approved';
            $wallet->morphable()->associate($order->user);
            $wallet->save();
        }

        $notify = [
            'success' => "Payment updated successfully.",
            'redirect' => route('ec-order.list'),
        ];
        return $notify;
    }

    public function edit(string $id)
    {
        $configStatuses = ConfigStatus::get();
        $paymentStatuses = PaymentStatus::get();
        $order = EcommerceOrder::findOrFail($id);
        return view('admin.ecommerce.order.edit', compact('order','paymentStatuses','configStatuses'));
    }

    public function update(Request $request, string $id)
    {
        $order = EcommerceOrder::findOrFail($id);
        
        $order->status = $request->status; 

        $order->courier = $request->courier;

        $order->parcel_status_id = $request->parcel_status_id;
      
        $order->external_awb = $request->external_awb;

        $order->tracking = $request->tracking;

        $order->payment_status_id = $request->payment_status;

        $order->status = 1;
        
        $order->save(); 

        if (isset($order) && isset($order->tracking)) {

            $this->addParcel($order);
        }


        // if (isset($request->send_invoice)) {
        //     $user = User::findOrFail($order->user_id);
        //     $template = EmailTemplate::where('slug', 'order-notify')->first();

        //     if ($template) {
        //         $notification = new OrderNotification(
        //             $template,
        //             [
        //                 'order_no' => $order->code,
        //                 'invoice_url' => route('purchasing.order.invoice.print', ['id' => $order->id]),
        //             ]
        //         );

        //         $user->notify($notification);
        //     } else {
        //         $notify = [
        //             'error' => "Something went wrong contact your admin.",
        //         ];
        //         return $notify;
        //     }
        // }
        $notify = [
            'success' => "Order updated successfully.",
            'redirect' => route('ec-order.list'),
        ];
        return $notify;
    }


    public function getPaymentHtml($id)
    {
        $payment = EcommerceOrder::select('id', 'payment_status_id', 'payment_receipt')->where('id', $id)->first();
        $paymentStatuses = PaymentStatus::get();
        return view('admin.ecommerce.order.payment', ['payment' => $payment, 'paymentStatuses' => $paymentStatuses]);
    }

    public function show(string $id)
    {
        $order = EcommerceOrder::findOrFail($id);
        $carts = EcommerceCart::where('order_id', $order->id)->get();
        $this->products = $carts;
        $cal = (object) $this->calc($carts[0]->currency_id);

        return view('admin.ecommerce.order.show', ['order' => $order, 'carts' => $carts, 'cal' => $cal]);
    }

    public function printInvoice($id)
    {
        $order = EcommerceOrder::findOrFail($id);
        $carts = EcommerceCart::where('order_id', $order->id)->get();
        $this->products = $carts;
        $cal = (object) $this->calc($carts[0]->currency_id);
        $barcode = $this->generateQRcode(route('ec-order.invoice.print', ['id' => $order->id]));
        return view('admin.ecommerce.order.print_invoice', compact('order', 'carts', 'barcode', 'cal'));
    }

    public function generateQRcode($data = null, $barcodeType = null)
    {
        $QRData = QrCode::generate($data);

        return $QRData;
    }

    public function updatePaymentStatus(Request $request)
    {
        $order = EcommerceOrder::findOrFail($request->id);

        $order->payment_status_id = $request->payment_status;

        if($request->payment_method)
            $order->payment_id = $request->payment_method;

        if ($request->payment_receipt) {

            $order->payment_receipt = $this->fileUpload($request->payment_receipt,$order->payment_receipt);
        }

        $order->save();
        $notify = ['success' => "Payment status updated."];

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

    public function calc($currencyId)
    {
        return [
            'shipping' => $this->getShipping(true),
            'tax' => $this->getTax(true),
            'total' => $this->getSubTotal(true),
            'paypal' =>  $this->paypalFee(true),
            'tenOrderFee' => $this->tenOrderFee(0, 'public', true),
            'adminFee' => $this->adminFee(true),
            'totalConverted' => $this->totalConverted($currencyId, true),
        ];
    }

    public function data(Request $request)
    {
        if($request->status == 'pending')
            $data = EcommerceOrder::where('status','new')->orWhere('status','process')->get();
        elseif($request->status == 'delivered')
            $data = EcommerceOrder::where('status','delivered')->get();
        elseif($request->status == 'cancelled')
            $data = EcommerceOrder::where('status','cancel')->get();
        else
            $data = EcommerceOrder::get();

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
                        <li><a class="dropdown-item order-data-view" href="' . route('ec-order.show', ['id' => $row->id]) . '">View</a></li>
                        <li><a class="dropdown-item order-data-edit" href="' . route('ec-order.edit', ['id' => $row->id]) . '">Edit</a></li>
                        <li><a class="dropdown-item order-data-invoice" href="' . route('ec-order.invoice.print', ['id' => $row->id]) . '" target="_blank">Print Invoice</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('status', function ($row) {

                return $row->status;
            })
            ->addColumn('payment_status', function ($row) {
                if (isset($row->paymentStatus->color)) {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal" data-order-id="' . $row->id . '" style="background-color:' . $row->paymentStatus->color . '">' . $row->paymentStatus->name . '</span></a>';
                } else {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal" data-order-id="' . $row->id . '">' . $row->paymentStatus->name . '</span></a>';
                }
                return $html;
            })
            ->addColumn('total', function ($row) {

                return (isset($row->total_amount) ? number_format($row->total_amount, 2) : '0.00');
            })
            ->addColumn('reciever', function ($row) {
                return (isset($row->shipperAddress) ? $row->shipperAddress->name . '-' . $row->shipperAddress->country->name : 'N/A');
            })
            ->addColumn('created_at', function ($row) {
                return (isset($row->created_at) ? $row->created_at->format('F j, Y h:i A') : 'N/A');
            })
            ->rawColumns(['action', 'status','payment_status', 'total', 'reciever'])
            ->make(true);
    }

    public function addParcel($order = null)
    {
        $orderCount = Parcel::whereHasMorph('orderable', [EcommerceOrder::class])
        ->where('orderable_id', $order->id)->count();

        if (isset($order->tracking) && $orderCount == 0) {

            $parcels = new Parcel();

            $parcels->invoice_no = $order->invoice;

            $parcels->waybill = $order->awb;

            $parcels->payment_status_id = $order->payment_status_id;

            $parcels->payment_id = $order->payment_id;

            $parcels->payment_receipt = $order->payment_receipt;  

            $parcels->parcel_status_id = $order->parcel_status_id;

            $parcels->delivery_method = 0;

            $parcels->show_delivery_date = 0;

            $parcels->important = 0;

            $parcels->show_invoice = 0;

            $parcels->external_shipper_id = $order->courier;

            $parcels->external_tracking = $order->tracking;

            $parcels->tax = $order->tax;

            $parcels->delivery_fee = $order->shipping_price;

            $parcels->discount = $order->discount;

            $parcels->quantity = $order->quantity;

            $parcels->weight = 0;

            $parcels->length = 0;

            $parcels->width =  0;

            $parcels->height = 0;

            $parcels->dimension = 0;

            $parcels->item_value = (isset($order->total_amount) ? $order->total_amount : 0);

            $parcels->reciever_address_id = (isset($order->shipping_id) ? $order->shipping_id : null); 

            $parcels->user_id = $order->user_id;

            $parcels->currency_id = $order->currency_id;

            $parcels->orderable()->associate($order);

            $parcels->save();

            $admin = Admin::first();
            //Send notification to user
            event(new ParcelEvent($parcels, $admin, 'CreateParcel')); 
       
            $user = User::findOrFail($parcels->user_id);
            //Send notification to user
            event(new ParcelEvent($parcels, $user, 'CreateParcel')); 

            $user = User::findOrFail($parcels->user_id);

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

                return $notify;
            }
        }
    }
    
}
