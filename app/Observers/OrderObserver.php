<?php

namespace App\Observers;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\PurchaseCart;

class OrderObserver
{
    public function saving(Order $data){
        foreach($data->purchase_id as $purchaseId){
            Purchase::where('id',$purchaseId)->update(['status' => 1]);
            PurchaseCart::where('purchase_id',$purchaseId)->delete();
        }
    }
}
