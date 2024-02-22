<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarMakeModel;
use App\Models\Currency;

class CarCalculatorController extends Controller
{
    public function index()
    {
        $makes = CarMakeModel::distinct('make')->pluck('make')->toArray();
        $currencyVal = Currency::where('code','USD')->pluck('value')->first();
        return view('admin.car-calculator.index',compact('makes','currencyVal'));
    }

    public function getModels(Request $request) {

        $models = CarMakeModel::where('make',$request->make)->pluck('model')->toArray();
        return $models;

    }
}
