<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Parcel;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Consolidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {   
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $data['parcels']  = Parcel::orderBy('id', 'desc')->whereNull('drafted_at')->whereNotIn('id', $ids)->get();
        $data['orders']  = Order::get();
        $data['consolidates']  = Consolidate::get();
        $data['customers']  = User::count();
        $data['approved_transactions']  = Wallet::where('status','approved')->sum('amount_converted');
        $data['payment_recieved']  = Parcel::where('payment_status_id',2)->sum('amount_total');
        $data['latest_wallets']  = Wallet::latest()->take(5)->get();
        $data['latest_orders']  = Order::latest()->take(5)->get();

        $currentYear = Carbon::now()->year;

        // graph data for total parcels counts month wise
        $parceCountByMonth = Parcel::selectRaw('MONTH(created_at) as month, 
                                SUM(CASE WHEN payment_status_id = "2" THEN 1 ELSE 0 END) as paid_count,
                                SUM(CASE WHEN payment_status_id = "1" THEN 1 ELSE 0 END) as unpaid_count,
                                SUM(CASE WHEN payment_status_id = "3" THEN 1 ELSE 0 END) as pending_count')
                    ->whereYear('created_at', $currentYear)
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
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $totalOrders = DB::table('orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $totalConsolidates = DB::table('consolidates')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $totalUsers = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $currentYear)
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

            if (!isset($totalUsers[$month])) {
                $totalUsers[$month] = 0;
            }
        }

        ksort($totalParcels);
        $totalParcelsArray = array_values($totalParcels);

        ksort($totalOrders);
        $totalOrdersArray = array_values($totalOrders);

        ksort($totalConsolidates);
        $totalConsolidatesArray = array_values($totalConsolidates);

        ksort($totalUsers);
        $totalUsersArray = array_values($totalUsers);




        return view('admin.dashboard',compact('data','parcelCountresult','totalParcelsArray','totalOrdersArray','totalConsolidatesArray','totalUsersArray'));
    }
}
