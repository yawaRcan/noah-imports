<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory , SoftDeletes;

    public function orderable()
    {
        return $this->morphTo();
    }

    public function parcelStatus()
    {
        return $this->belongsTo(ConfigStatus::class, 'parcel_status_id');
    }

    public function parcelDeliveryInfo()
    {
        return $this->hasOne(ParcelDelivery::class, 'parcel_id');
    }
    

    public function parcelImages()
    {
        return $this->hasMany(ParcelImage::class, 'parcel_id');
    }
     public function parcelImage(){
       
        
       return $this->parcelImages()->oldest()->limit(1);
       
    } 
    
    public function sender()
    {
        return $this->belongsTo(ShippingAddress::class, 'sender_address_id');
    }

    public function reciever()
    {
        return $this->belongsTo(ShippingAddress::class, 'reciever_address_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
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
        return $this->belongsTo(ShipmentMode::class, 'shipment_mode_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function duty()
    {
        return $this->belongsTo(ImportDuty::class, 'import_duty_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function consolidate()
    {
        return $this->belongsToMany(Consolidate::class, 'consolidate_');
    }

}
