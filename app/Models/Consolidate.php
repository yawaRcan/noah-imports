<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Consolidate extends Model
{
    use HasFactory;

    public function parcels()
    {
        return $this->belongsToMany(Parcel::class, 'consolidate_pivot');
    }

    public function parcelStatus()
    {
        return $this->belongsTo(ConfigStatus::class, 'parcel_status_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }
    
    public function sender()
    {
        return $this->belongsTo(ShippingAddress::class, 'sender_address_id');
    }

    public function reciever()
    {
        return $this->belongsTo(ShippingAddress::class, 'reciever_address_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function toCountry()
    {
        return $this->belongsTo(Country::class, 'to_country_id');
    }

    public function fromCountry()
    {
        return $this->belongsTo(Country::class, 'from_country_id');
    }

    public function externalShipper()
    {
        return $this->belongsTo(ExternalShipper::class, 'external_shipper_id');
    }

    public function shipmentType()
    {
        return $this->belongsTo(ShipmentType::class, 'shipment_type_id');
    }

    public function shipmentMode()
    {
        return $this->belongsTo(ShipmentMode::class, 'shipment_type_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    } 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    
}
