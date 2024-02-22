<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\Parcel;
use App\Events\ParcelEvent;
use App\Models\ParcelImage;
use App\Models\Consolidate;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use App\Models\PickupStation;
use App\Traits\AirCalculator;
use App\Traits\SeaCalculator;
use App\Models\ShippingAddress;
use App\Events\ConsolidateEvent;
use App\Models\ConsolidateImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ConsolidateController extends Controller
{
    use AirCalculator, SeaCalculator;

    protected $parcelArr = array();
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.consolidate.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.consolidate.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 500);
        ini_set('memory_limit', '700M');
        $parcelsCount = Parcel::whereNotNull('freight_type')->whereIn('id', $request->arr)->count();

        if (count($request->arr) != $parcelsCount) {
            $notify = [
                'error' => "Select parcels with complete data",
            ];
            return $notify;
        }


        $parcel = Parcel::findOrFail($request->arr[0]);

        $id = Consolidate::orderBy('id', 'desc')->pluck('id')->first();

        if ($id) {
            $id = $id + 1;
        } else {
            $id = 1;
        }

        // dd('cosolidate');
        $Consolidate = new Consolidate();

        $Consolidate->user_id = $parcel->user_id;

        $Consolidate->invoice_no = general_setting('setting')->invoice_no . $id;

        $Consolidate->waybill = general_setting('setting')->waybil_no . $id;

        $Consolidate->external_waybill = 0;

        $Consolidate->reciever_address_id = $parcel->reciever_address_id;

        $Consolidate->sender_address_id = $parcel->sender_address_id;

        $Consolidate->branch_id = $this->branch = $parcel->branch_id;

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

        $Consolidate->amount_total = 0;

        $Consolidate->save();

        $Consolidate->parcels()->attach($request->arr);

        $admin = Admin::first();

        $user = User::findOrFail($Consolidate->user_id);

        $template = EmailTemplate::where('slug', 'new-consolidate')->first();

        if ($template) {

            $shortCodes = [
                'tracking_no' => $Consolidate->external_tracking,
                'delivery_time' => $Consolidate->es_delivery_date,
                'invoice_url' => route('consolidate.invoice', ['id' => $Consolidate->id]),
                'name' => $user->username
            ];


            //Send notification to user
            event(new ConsolidateEvent($template, $shortCodes, $Consolidate, $admin, 'CreateConsolidate'));

            //Send notification to user
            // event(new ConsolidateEvent($template, $shortCodes, $Consolidate, $user, 'CreateConsolidate'));

        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
        }

        $Consolidate->amount_total = $this->consolidateCalc($Consolidate)['total'];

        $Consolidate->save();

        $template = EmailTemplate::where('slug', 'consolidate-parcel')->first();

        if ($template) {

            $shortCodes = [
                'tracking_no' => $Consolidate->external_tracking,
                'delivery_time' => $Consolidate->es_delivery_date,
                'invoice_url' => route('consolidate.invoice', ['id' => $Consolidate->id]),
            ];

            //Send notification to user
            event(new ParcelEvent($template, $shortCodes, $Consolidate, $user, 'ConsolidateParcel'));

        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
        }


        $notify = [
            'success' => "Consolidate has been added.",
            'redirect' => route('consolidate.index'),
        ];

        return $notify;
    }

    //Get shipping calculator info
    function getShippingCalculator($branch_id, $type, $import, $ob, $length, $width, $height, $actual_weight, $item, $discount, $shipping = 0, $tax = 0)
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
        $total = $this->consolidateCalc($consolidate, true);
        return view('admin.consolidate.show', ['consolidate' => $consolidate, 'parcels' => $parcels, 'total' => $total]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $consolidate = Consolidate::findOrFail($id);
        $shipmentAddress = ShippingAddress::whereHasMorph('morphable', [Admin::class])
            ->where('morphable_id', Auth::user()->id)->get();

        $shipmentAddressRecive = ShippingAddress::whereHasMorph('morphable', [User::class])
            ->where('morphable_id', $consolidate->user_id)->get();
        $paymentStatuses = PaymentStatus::get();
        return view('admin.consolidate.edit', ['consolidate' => $consolidate, 'shipmentAddress' => $shipmentAddress, 'shipmentAddressRecive' => $shipmentAddressRecive, 'paymentStatuses' => $paymentStatuses]);
    }

    public function getPickupStation(Request $request)
    {

        $consolidate = '';
        $pickupStation = PickupStation::get();
        if ($request->consolidate_id) {
            $consolidate = Consolidate::findOrFail($request->consolidate_id);
        }

        return view('admin.consolidate.ajax.pickup-station', ['pickupStation' => $pickupStation, 'consolidate' => $consolidate]);
    }

    public function itemEdit(string $id)
    {
        $parcel = Parcel::findOrFail($id);
        return view('admin.consolidate.ajax.edit', ['parcel' => $parcel]);
    }

    public function itemUpdate(Request $request, string $id)
    {
        $parcel = Parcel::findOrFail($id);

        $parcel->import_duty_id = (isset($request->import_duties) ? $request->import_duties : 1);

        $parcel->quantity = (isset($request->quantity) ? $request->quantity : 0);

        $parcel->weight = $this->weight = (isset($request->weight) ? $request->weight : 0);

        $parcel->length = $this->length = (isset($request->length_inch) ? $request->length_inch : 0);

        $parcel->width = $this->width = (isset($request->width_inch) ? $request->width_inch : 0);

        $parcel->height = $this->height = (isset($request->height_inch) ? $request->height_inch : 0);

        $parcel->dimension = (isset($request->dimention) ? $request->dimention : 0);

        $parcel->delivery_fee = (isset($request->delivery_fees) ? $request->delivery_fees : 0);

        $parcel->discount = (isset($request->discount) ? $request->discount : 0);

        $parcel->item_value = (isset($request->item_value) ? $request->item_value : 0);

        $parcel->ob_fees = (isset($request->ob_fees) ? $request->ob_fees : 1);

        $parcel->tax = (isset($request->tax) ? $request->tax : 0);

        $parcel->product_description = (isset($request->product_desc) ? $request->product_desc : '');

        $parcel->save();

        $table = view('admin.consolidate.ajax.table', ['parcel' => $parcel])->render();

        $html = ['selector' => 'consolidate-item-row-' . $parcel->id, 'data' => $table];

        $notify = [
            'success' => "Item has been updated.",
            'html' => $html,
        ];

        return $notify;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Consolidate = Consolidate::with('parcelStatus')->findOrFail($id);

        $Consolidate->sender_address_id = $request->sender_ship_address;

        $Consolidate->reciever_address_id = $request->reciver_ship_address;

        $Consolidate->external_waybill = $request->external_awb;

        $Consolidate->branch_id = $request->branch_id;

        $Consolidate->from_country_id = $request->from_country;

        $Consolidate->to_country_id = $request->to_country;

        $Consolidate->external_shipper_id = $request->external_shpper;

        $Consolidate->freight_type = $request->freight_type;

        $Consolidate->shipment_type_id = $request->shipment_type;

        $Consolidate->shipment_mode_id = $request->shipment_mode;

        if (isset($request->parcel_status) && $Consolidate->parcel_status_id != $request->parcel_status) {

            $Consolidate->parcel_status_id = $request->parcel_status;

            $statusFlag = 1;

        } else {
            $statusFlag = 0;
        }

        $Consolidate->payment_status_id = $request->payment_status;

        $Consolidate->external_tracking = $request->external_tracking;

        $Consolidate->es_delivery_date = $request->estimate_delivery_date;

        $Consolidate->comment = $request->comment;

        $Consolidate->delivery_method = $request->delivery_method;

        if ($request->delivery_method > 0) {

            $Consolidate->pickup_station_id = $request->pickup_station;
        }

        if ($request->payment_file) {
            $Consolidate->payment_receipt = $this->fileUpload($request->payment_file);
        }

        $Consolidate->save();

        $Consolidate->load('parcelStatus');

        $admin = Admin::first();

        $user = User::findOrFail($Consolidate->user_id);

        $template = EmailTemplate::where('slug', 'update-consolidate')->first();

        if ($template) {

            $shortCodes = [
                'tracking_no' => $Consolidate->external_tracking,
                'delivery_time' => $Consolidate->es_delivery_date,
                'invoice_url' => route('consolidate.invoice', ['id' => $Consolidate->id]),
            ];

            //Send notification to user
            event(new ConsolidateEvent($template, $shortCodes, $Consolidate, $admin, 'UpdateConsolidate'));

            event(new ConsolidateEvent($template, $shortCodes, $Consolidate, $user, 'UpdateConsolidate'));

        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
        }



        if (isset($request->parcel_status) && $statusFlag == 1) {

            $template = EmailTemplate::where('slug', 'consolidate-status')->first();

            if ($template) {

                $shortCodes = [
                    'tracking_no' => $Consolidate->external_tracking,
                    'consolidate_status' => $Consolidate->parcelStatus->name,
                    'delivery_time' => $Consolidate->es_delivery_date,
                    'invoice_url' => route('consolidate.invoice', ['id' => $Consolidate->id]),
                ];

                //Send notification to user
                event(new ConsolidateEvent($template, $shortCodes, $Consolidate, $admin, 'ConsolidateStatus'));

                event(new ConsolidateEvent($template, $shortCodes, $Consolidate, $user, 'ConsolidateStatus'));

            } else {

                $notify = [
                    'error' => "Something went wrong contact your admin.",
                ];
            }

        }


        $notify = [
            'success' => "Consolidate has been updated.",
            'redirect' => route('consolidate.index'),
            'id' => $Consolidate->id,
        ];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Consolidate::findOrFail($id)->delete();

        $notify = ['success' => "Consolidate has been deleted."];

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

    /**
     * Remove the specified resource from storage.
     */
    public function itemDestroy(string $id, string $cid)
    {
        $consolidate = Consolidate::findOrFail($cid);

        $consolidate->parcels()->detach($id);

        $parcels = $consolidate->parcels()->get();

        if (count($parcels) <= 1) {

            $del = DB::table('consolidate_pivot')->where('consolidate_id', $cid)->delete();
            $consolidate->delete();


            $notify = [
                'success' => "Item has been deleted.",
                'remove' => 'consolidate-item-row-' . $id,
                'redirect' => route('consolidate.index'),
            ];

            return $notify;
        } else {
            $consolidate->amount_total = $parcels->sum('amount_total');
            $consolidate->save();
        }

        $notify = [
            'success' => "Item has been deleted.",
            'remove' => 'consolidate-item-row-' . $id,
        ];

        return $notify;
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

        $total = $this->consolidateCalc($invoice);

        $parcels = $this->parcelArr;

        return view('admin.consolidate.invoice-print', compact('invoice', 'total', 'barcode', 'parcels'));
    }

    public function getPaymentHtml($id)
    {

        $payment = Consolidate::select('id', 'payment_status_id', 'payment_receipt')->where('id', $id)->first();

        $paymentStatuses = PaymentStatus::get();

        return view('admin.consolidate.ajax.payment', ['payment' => $payment, 'paymentStatuses' => $paymentStatuses]);
    }

    public function approvedPayment($id)
    {
        $payment = Consolidate::findOrFail($id);

        $payment->payment_status_id = 1;

        $payment->save();

        $notify = ['success' => "Payment has been approved."];

        return $notify;
    }

    public function updatePaymentStatus(Request $request)
    {
        $payment = Consolidate::with('paymentStatus')->findOrFail($request->id);

        $payment->payment_status_id = $request->payment_status;

        if ($request->payment_method)
            $payment->payment_id = $request->payment_method;

        if ($request->payment_receipt) {

            $payment->payment_receipt = $this->fileUpload($request->payment_receipt, $payment->payment_receipt);
        }

        $payment->save();

        $payment->load('paymentStatus');

        $admin = Admin::first();

        $user = User::findOrFail($payment->user_id);

        $template = EmailTemplate::where('slug', 'consolidate-payment-status')->first();

        if ($template) {

            $shortCodes = [
                'tracking_no' => $payment->external_tracking,
                'consolidate_status' => $payment->parcelStatus->name,
                'consolidate_payment_status' => $payment->paymentStatus->name,
                'delivery_time' => $payment->es_delivery_date,
                'invoice_url' => route('consolidate.invoice', ['id' => $payment->id]),
            ];

            //Send notification to user
            event(new ConsolidateEvent($template, $shortCodes, $payment, $admin, 'ConsolidatePaymentStatus'));

            event(new ConsolidateEvent($template, $shortCodes, $payment, $user, 'ConsolidatePaymentStatus'));

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
        $payment = Consolidate::findOrFail($id);

        if ($payment->show_invoice == 0) {

            $payment->show_invoice = 1;
        } else {

            $payment->show_invoice = 0;
        }

        $payment->save();

        $notify = ['success' => "Invoice status has been changed."];

        return $notify;
    }

    public function generateQRcode($data = null, $barcodeType = null)
    {

        $QRData = QrCode::generate($data);
        ;

        return $QRData;
    }

    function consolidateCalc($invoice, $bol = false)
    {

        $parcels = $invoice->parcels()->get()->toArray();
        if (count($this->parcelArr) > 0) {
            $parcels = $this->parcelArr;
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
                $amount[$key] = $ship['data']['chargeable_weight_amount'] :
                $amount[$key] = $ship['data']['chargeable_dimension'];
        }

        if ($bol) {
            return $data['total'] = $total;
        }
        // dd($import_duty,$import_duty_percent);
        return $data['total'] = [
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

        if (isset($request->user_id) && $request->user_id != '' && $request->user_id != null) {
            $data = Consolidate::where('user_id', $request->user_id)->get();
        } else {
            $data = Consolidate::get();
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
                    <li><a class="dropdown-item consolidate-data-view" href="' . route('consolidate.show', [$row->id]) . '" data-consolidate-id=' . $row->id . '>View</a></li>
                    <li><a class="dropdown-item consolidate-data-edit" href="' . route('consolidate.edit', [$row->id]) . '" data-consolidate-id=' . $row->id . '>Edit</a></li>
                    <li><a class="dropdown-item consolidate-data-invoice" href="' . route('consolidate.invoice', [$row->id]) . '" target="_blank">Print Invoice</a></li> 
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
            ->addColumn('invoice_status', function ($row) {

                if ($row->show_invoice == 0) {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-danger ni-invoice-status" data-consolidate-id="' . $row->id . '">Disabled</span></a>';
                } else {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-success ni-invoice-status" data-consolidate-id="' . $row->id . '">Enabled</span></a>';
                }

                return $html;
            })
            ->addColumn('payment', function ($row) {
                if ($row->paymentStatus->slug == 'paid') {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-success" data-consolidate-id="' . $row->id . '">' . $row->paymentStatus->name . '</span>&nbsp;<img class="ni-payment-show-modal" data-consolidate-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                } else {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge ni-payment-show-modal bg-danger" data-consolidate-id="' . $row->id . '">Unpaid</span>&nbsp;<img class="ni-payment-show-modal" data-consolidate-id="' . $row->id . '" src="' . asset("assets/icons/" . $row->payment->icon) . '" width="30px" /></a>';
                }
                return $html;
            })
            ->addColumn('amount', function ($row) {

                $total = $this->consolidateCalc($row);

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
            ->rawColumns(['action', 'created_at', 'status', 'invoice_status', 'payment', 'amount', 'reciever', 'sender', 'invoice'])
            ->make(true);
    }

    public function imagesGet($id)
    {
        $consolidate = Consolidate::findOrFail($id);
        $parcelIds = $consolidate->parcels->pluck('id');
        $images = ParcelImage::whereIn('parcel_id', $parcelIds)->get();

        return view('admin.consolidate.images', compact('images'));
    }

    public function updateDeliveryDate(Request $request)
    {
        if ($request->eventType == 'consolidate') {

            $id = str_replace('c-', '', $request->id);
            $consolidate = Consolidate::findOrFail($id);
            $consolidate->es_delivery_date = $request->droppedDate;
            $consolidate->save();
        }

        $notify = ['success' => "Consolidate delivery date updated successfully"];

        return $notify;
    }

    public function fileStore(Request $request)
    {
        $this->fileUploadMultiple($request->file, $request->consolidate_id);

    }

    public function fileUploadMultiple($files, $id = null)
    {

        if (isset($files)) {

            foreach ($files as $key => $value) {

                $consolidateImage = new ConsolidateImage();

                $consolidateImage->name = $value->getClientOriginalName();

                $consolidateImage->hash_name = $value->hashName();

                $consolidateImage->size = $value->getSize();

                $consolidateImage->type = $value->getClientOriginalExtension();

                $consolidateImage->consolidate_id = $id;

                $consolidateImage->save();

                $value->storeAs('assets/consolidate/', $value->hashName());
            }
        }
    }
}
