<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\AirCalculator;
use App\Traits\SeaCalculator;
use App\Http\Controllers\Controller;

class ShippingCalculatorController extends Controller
{
    use AirCalculator, SeaCalculator;
    function index()
    {
        return view('admin.shipping-calculator.index');
    }

    function store(Request $request)
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
            0,
            0,
            0
        );

        if ($request->freight_type == 'air-freight') {
            $html = view('admin.shipping-calculator.ajax.air-calculate', compact('total'))->render();
        } else {
            $html = view('admin.shipping-calculator.ajax.sea-calculate', compact('total'))->render();
        }

        $notify = [
            'success' => "Success",
            'html' => ['selector' => 'data-air-info', 'data' => $html]
        ];
        return $notify;
    }

    //Get shipping calculator info
    function getShippingCalculator($branch_id, $type, $import, $ob, $length, $width, $height, $actual_weight, $item, $discount = 0, $shipping = 0, $tax = 0, $discount_type = 'ship')
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
