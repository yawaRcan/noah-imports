<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Parcel;
use App\Models\Consolidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{

    public function index()
    {   
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $data['parcels']  = Parcel::orderBy('id', 'desc')->whereNull('drafted_at')->whereNotIn('id', $ids)->get();
        $data['orders']  = Order::get();
        $data['consolidates']  = Consolidate::get();
        return view('admin.calendar.index',compact('data'));
        
    }

   public function parcels() {
        $parcels = Parcel::get();
       return view('admin.calendar.parcel',compact('parcels'));
    }

    public function orders() {
        $orders = Order::get();
       return view('admin.calendar.order',compact('orders'));
    }
    public function consolidates() {
        $consolidates = Consolidate::get();
       return view('admin.calendar.consolidate',compact('consolidates'));
    }
    
}
