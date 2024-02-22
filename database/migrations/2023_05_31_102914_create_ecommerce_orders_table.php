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
        Schema::create('ecommerce_orders', function (Blueprint $table) {
            $table->id();   
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('payment_status_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('code')->nullable();
            $table->smallInteger('courier')->nullable();
            $table->string('invoice')->nullable();
            $table->tinyInteger('parcel_status_id')->nullable();
            $table->string('awb')->nullable();
            $table->string('external_awb')->nullable();
            $table->string('tracking')->nullable();
            $table->string('external_status')->nullable();
            $table->double('shipping_price')->nullable();
            $table->double('tax')->nullable();
            $table->double('insurance_tax')->nullable();
            $table->double('discount')->nullable();
            $table->float('coupon')->nullable();
            $table->float('sub_total')->nullable(); 
            $table->float('total_amount')->nullable();
            $table->float('total_converted')->nullable();
            $table->integer('quantity')->nullable();  
            $table->enum('status',['new','process','delivered','cancel'])->default('new');  
            $table->string('payment_receipt')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('shipping_id')->references('id')->on('shipping_addresses')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerce_orders');
    }
};
