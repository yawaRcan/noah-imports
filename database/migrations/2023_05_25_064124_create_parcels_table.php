<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('waybill')->nullable(); 
            $table->string('external_waybill')->nullable(); 
            $table->morphs('orderable');
            $table->bigInteger('purchase_id')->unsigned()->index()->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('reciever_address_id')->unsigned()->index()->nullable();
            $table->foreign('reciever_address_id')->references('id')->on('shipping_addresses')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('sender_address_id')->unsigned()->index()->nullable();
            $table->foreign('sender_address_id')->references('id')->on('shipping_addresses')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('branch_id')->unsigned()->index()->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL')->onUpdate('cascade');

            $table->bigInteger('payment_status_id')->unsigned()->index()->nullable();
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses')->onDelete('SET NULL')->onUpdate('cascade');

            $table->bigInteger('from_country_id')->unsigned()->index()->nullable();
            $table->foreign('from_country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('to_country_id')->unsigned()->index()->nullable();
            $table->foreign('to_country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('external_shipper_id')->unsigned()->index()->nullable();
            $table->foreign('external_shipper_id')->references('id')->on('external_shippers')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('shipment_type_id')->unsigned()->index()->nullable();
            $table->foreign('shipment_type_id')->references('id')->on('shipment_types')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('shipment_mode_id')->unsigned()->index()->nullable();
            $table->foreign('shipment_mode_id')->references('id')->on('shipment_modes')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('import_duty_id')->unsigned()->index()->nullable();
            $table->foreign('import_duty_id')->references('id')->on('import_duties')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('pickup_station_id')->unsigned()->index()->nullable();
            $table->foreign('pickup_station_id')->references('id')->on('pickup_stations')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('parcel_status_id')->unsigned()->index()->nullable();
            $table->foreign('parcel_status_id')->references('id')->on('config_statuses')->onDelete('SET NULL')->onUpdate('cascade'); 
            $table->bigInteger('payment_id')->unsigned()->index()->nullable();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('currency_id')->unsigned()->index()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL')->onUpdate('cascade');
            $table->tinyInteger('delivery_method')->nullable();
            $table->string('es_delivery_date')->nullable();
            $table->double('delivery_fee')->nullable();
            $table->double('discount')->nullable();
            $table->double('ob_fees')->nullable();
            $table->double('item_value')->nullable();
            $table->double('tax')->nullable();
            $table->tinyInteger('important')->nullable(); 
            $table->tinyInteger('show_delivery_date')->nullable(); 
            $table->tinyInteger('show_invoice')->nullable(); 
            $table->string('freight_type')->nullable();
            $table->text('product_description')->nullable();
            $table->string('comment')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('weight')->nullable();
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('dimension')->nullable();
            $table->string('external_tracking')->nullable();
            $table->string('external_status')->nullable();
            $table->string('payment_receipt')->nullable(); 
            $table->double('amount_total')->nullable();  
            $table->string('discount_type')->default('ship');  
            $table->timestamps();
            $table->timestamp('drafted_at')->nullable(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
