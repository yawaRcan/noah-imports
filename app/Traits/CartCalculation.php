<?php

namespace App\Traits;

use App\Models\Currency;

trait CartCalculation
{
    public $product_id;
    public $website;
    public $size;
    public $color;
    public $add_note;
    public $qty;
    public $price;
    public $currency;
    public $products;


    function __construct()
    {
        $this->product_id = $this->generateOrderID();
        $this->products = [];
    }

    //generate order id
    public function generateOrderID()
    {
        return rand(10000000, 99999999) . substr(strtotime("now"), 8, 10);
    }

    //fetch product from cart
    public function fetchCart($code)
    {
        foreach ($this->products as $item) {
            if ($item->product_id === $code) {
                return $item;
            }
        }
    }

    //get product info in cart
    public function getProduct($product)
    {
        foreach ($this->products as $item) {
            if ($item->product_id === $product->product_id)
                return $item;
        }
    }

    //get cost of each item
    public function getSingleCost($product, $format = false)
    {
        $total = 0;
        foreach ($this->products as $item) {
            if ($item->product_id === $product->product_id) {
                $total = $item->price * $item->qty;
                break;
            }
        }
        return $format ? number_format($total) : $total;
    }

    //calculate sub total
    public function getSubTotal($format = false)
    {
        $sum = 0;

        foreach ($this->products as $item) {
            $sum += $item->price * $item->quantity;

        }
        // dd(doubleval(intval($this->getShipping(true)) + intval($this->getTax(true))));
        $sum += doubleval(intval($this->getShipping(true)) + intval($this->getTax(true)));
        return $format ? number_format($sum, 2) : $sum;
    }

    //calculate Total Shiping
    public function getShipping($format = false)
    {
        $sum = 0;

        foreach ($this->products as $item) {
            $sum += $item->shipping_price;
            // dump($sum);
        }
        return $format ? number_format($sum, 2) : $sum;
    }

    //calculate Total Shiping
    public function getTax($format = false)
    {
        $sum = 0;

        foreach ($this->products as $item) {
            $sum += $item->tax;
        }
        return $format ? number_format($sum, 2) : $sum;
    }

    //paypal fee 
    public function paypalFee($format = false)
    {
        $cal = ($this->getSubTotal() * 4.62 / 100) + 0.3;
        return $format ? number_format($cal, 2) : $cal;
    }

    //Item Price & Administration Fee+ Paypal
    public function adminFee($format = false)
    {
        $cal = $this->getSubTotal() + $this->paypalFee() + 3.1;
        return $format ? number_format($cal, 2) : $cal;
    }

    //10% order fee
    public function tenOrderFee($discount = 0, $type = 'private', $format = false)
    {
        // dd($discount);
        $cal = ($this->adminFee() * 1.1) + 2;
        $percent = ($cal * $discount) / 100;
        $total = $cal - $percent;

        if ($type == 'private') {
            return $format ? number_format($cal, 2) : $total;
            // dd($total);
        } else {
            return $format ? number_format($total, 2) : $total;
        }
    }

    //get service charge fee
    public function serviceChargeFee($format = false)
    {
        $cal = (float) $this->tenOrderFee() - (float) $this->getSubTotal();
        return $format ? number_format($cal, 2) : (float) $cal;
    }

    //calculate discount
    public function discount($discount = 0, $format = false)
    {
        $discount = (float) $discount;
        $percent = ($this->tenOrderFee($discount) * $discount) / 100;
        return $format ? number_format($percent, 2) : $percent;
    }

    //calculate total from selected currency of shopping
    public function total($format = false, $discount = null)
    {


        return $format ? number_format($this->tenOrderFee($discount), 2) : $this->tenOrderFee($discount);
    }

    //calculate total from selected currency of shopping
    public function totalDiscounted($discount, $type = 'public', $format = false)
    {

        return $format ? number_format($this->tenOrderFee($discount, $type), 2) : $this->tenOrderFee($discount, $type);
    }

    //calculate total from coverted currency
    private function totalConverted($currency, $format = false, $discount = null)
    {
        //getting the cart currency with value
        $getCartCurrency = $this->getCurrency($currency)->value;

        //getting the site default currency with value
        // $defaultCurrency = $this->getCurrency('USD')->value;

        // check if currency is same as default
        // if ($currency == 1) {
        //     $cal = $this->total();
        // } else {
        $cal = $this->total(false, $discount) * $getCartCurrency;

        // }

        return $format ? number_format($cal, 2) : $cal;
    }

    //grand total calculation
    public function grandTotal($currency, $format = false, $shipping = 0, $tax = 0, $discount = 0)
    {
        $shipping = (float) $shipping;
        $tax = (float) $tax;
        $discount = (float) $discount;
        $cal = $this->totalConverted($currency) + $shipping + $tax;
        $percent = ($cal * $discount) / 100;
        $total = $cal - $percent;
        $total = $total > 0 ? $total : $cal;

        return $format ? number_format($total, 2) : $total;
    }

    //count cart items 
    public function getCount()
    {
        $sum = 0;
        foreach ($this->products as $item) {
            $sum += $item->qty;
        }
        return $sum > 99 ? "99+" : $sum;
    }

    function getCurrency($currency)
    {
        $currency = Currency::findOrFail($currency);

        return $currency;

    }
}
