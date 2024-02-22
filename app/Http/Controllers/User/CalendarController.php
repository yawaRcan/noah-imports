<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Parcel;
use App\Models\Consolidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    public function index()
    {   
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $data['parcels']  = Parcel::where('user_id',Auth::guard('web')->user()->id)->orderBy('id', 'desc')->whereNull('drafted_at')->whereNotIn('id', $ids)->get();
        $data['orders']  = Order::where('user_id',Auth::guard('web')->user()->id)->get();
        $data['consolidates']  = Consolidate::where('user_id',Auth::guard('web')->user()->id)->get();
        return view('user.calendar.index',compact('data'));
        
    }

   public function parcels() {
        $parcels = Parcel::where('user_id',Auth::guard('web')->user()->id)->get();
       return view('user.calendar.parcel',compact('parcels'));
    }

    public function orders() {
        $orders = Order::where('user_id',Auth::guard('web')->user()->id)->get();
       return view('user.calendar.order',compact('orders'));
    }
    public function consolidates() {
        $consolidates = Consolidate::where('user_id',Auth::guard('web')->user()->id)->get();
       return view('user.calendar.consolidate',compact('consolidates'));
    }
    
}
