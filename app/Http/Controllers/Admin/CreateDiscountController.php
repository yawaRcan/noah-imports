<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreateDiscount;
use Illuminate\Http\Request;

class CreateDiscountController extends Controller
{
    public function create(Request $request)
    {
        $discount = CreateDiscount::create([
            'discount' => $request->discVal
        ]);
        return response()->json(['discount' => $discount->discount]);
    }
}
