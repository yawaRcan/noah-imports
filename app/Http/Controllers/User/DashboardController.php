<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon; 
use App\Models\Order;
use App\Models\Parcel;
use App\Models\Branch;
use App\Models\Wallet; 
use App\Models\User;
use App\Models\Consolidate;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\AirCalculator;
use App\Traits\SeaCalculator;

class DashboardController extends Controller
{
    use AirCalculator, SeaCalculator;

    public function index()
    {   
        $user = User::findOrFail(Auth::guard('web')->user()->id);
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $data['parcels']  = Parcel::where('user_id',Auth::guard('web')->user()->id)->orderBy('id', 'desc')->whereNull('drafted_at')->whereNotIn('id', $ids)->get();
        $data['orders']  = Order::where('user_id',Auth::guard('web')->user()->id)->get();
        $data['consolidates']  = Consolidate::where('user_id',Auth::guard('web')->user()->id)->get();
        $data['approved_transactions']  = Wallet::where('morphable_id',Auth::guard('web')->user()->id)->where('status','approved')->sum('amount_converted');
        $data['payment_recieved']  = Parcel::where('user_id',Auth::guard('web')->user()->id)->where('payment_status_id',2)->sum('amount_total');
        $data['latest_wallets']  = Wallet::where('morphable_id',Auth::guard('web')->user()->id)->latest()->take(5)->get();
        $data['latest_orders']  = Order::where('user_id',Auth::guard('web')->user()->id)->latest()->take(5)->get();

        $data['latest_parcels']  = Parcel::where('user_id',Auth::guard('web')->user()->id)->latest()->take(5)->get();

        $data['branches']  = Branch::get();

        $total = [];
        foreach ($data['latest_parcels'] as $key => $value) {
            $total[]= $this->getShippingCalculator(
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

        $currentYear = Carbon::now()->year;

        // graph data for total parcels counts month wise
        $parceCountByMonth = Parcel::selectRaw('MONTH(created_at) as month, 
                                SUM(CASE WHEN payment_status_id = "2" THEN 1 ELSE 0 END) as paid_count,
                                SUM(CASE WHEN payment_status_id = "1" THEN 1 ELSE 0 END) as unpaid_count,
                                SUM(CASE WHEN payment_status_id = "3" THEN 1 ELSE 0 END) as pending_count')
                    ->whereYear('created_at', $currentYear)
                    ->where('user_id',Auth::guard('web')->user()->id)
                    ->groupBy('month')
                    ->get()
                    ->groupBy('month')
                    ->map(function ($items) {
                        return [
                            'paid_count' => $items->sum('paid_count'),
                            'unpaid_count' => $items->sum('unpaid_count'),
                            'pending_count' => $items->sum('pending_count'),
                        ];
                    })
                    ->toArray();

        // Initialize empty arrays for each count
        $paidCountArray = array_fill(1, 12, 0);
        $unpaidCountArray = array_fill(1, 12, 0);
        $pendingCountArray = array_fill(1, 12, 0);

        // Fill the count arrays with the actual values
        foreach ($parceCountByMonth as $month => $count) {
            $paidCountArray[$month] = $count['paid_count'];
            $unpaidCountArray[$month] = $count['unpaid_count'];
            $pendingCountArray[$month] = $count['pending_count'];
        }
        $parcelCountresult = [
            'paid_count' => $paidCountArray,
            'unpaid_count' => $unpaidCountArray,
            'pending_count' => $pendingCountArray,
        ];

        $totalParcels = DB::table('parcels')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $currentYear)
            ->where('user_id',Auth::guard('web')->user()->id)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $totalOrders = DB::table('orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $currentYear)
            ->where('user_id',Auth::guard('web')->user()->id)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $totalConsolidates = DB::table('consolidates')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $currentYear)
            ->where('user_id',Auth::guard('web')->user()->id)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill in any missing months with 0 count
        for ($month = 1; $month <= 12; $month++) {
            if (!isset($totalParcels[$month])) {
                $totalParcels[$month] = 0;
            }

            if (!isset($totalOrders[$month])) {
                $totalOrders[$month] = 0;
            }

            if (!isset($totalConsolidates[$month])) {
                $totalConsolidates[$month] = 0;
            }
        }

        ksort($totalParcels);
        $totalParcelsArray = array_values($totalParcels);

        ksort($totalOrders);
        $totalOrdersArray = array_values($totalOrders);

        ksort($totalConsolidates);
        $totalConsolidatesArray = array_values($totalConsolidates);

        $shippingAddresses = ShippingAddress::whereHasMorph('morphable', [User::class])->get();


        return view('user.dashboard',compact('data','parcelCountresult','totalParcelsArray','totalOrdersArray','totalConsolidatesArray','user','shippingAddresses','total'));
    }

    public function checkShipper() { 
 
        $user=auth()->user();
        return view('user.parcel.reciever',compact('user'))->render();

    }

    //Get shipping calculator info
    function getShippingCalculator($branch_id, $type, $import, $ob, $length, $width, $height, $actual_weight, $item, $discount, $shipping = 0, $tax = 0, $discount_type = 'ship')
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

            $this->discount_type =  $discount_type;

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

            $this->discount_type =  $discount_type;

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
}
