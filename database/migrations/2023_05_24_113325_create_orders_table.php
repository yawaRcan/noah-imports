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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->nullable()->constrained();
            $table->text('purchase_id')->nullable();
            $table->bigInteger('payment_id')->unsigned()->index()->nullable()->constrained();
            $table->bigInteger('shipping_address_id')->unsigned()->index()->nullable()->constrained();
            $table->bigInteger('currency_id')->unsigned()->index()->nullable()->constrained();
            $table->bigInteger('payment_status_id')->unsigned()->index()->nullable()->constrained();
            $table->string('code')->nullable();
            $table->smallInteger('courier')->nullable();
            $table->string('invoice',100)->nullable();
            $table->tinyInteger('delivery_status')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('awb',100)->nullable();
            $table->string('external_awb',100)->nullable();
            $table->string('tracking', 100)->nullable();
            $table->string('external_status', 50)->nullable();
            $table->double('shipping_price', 20)->nullable();
            $table->double('tax', 20)->nullable();
            $table->double('insurance_tax', 20)->nullable();
            $table->double('discount', 20)->nullable();
            $table->integer('total_qty')->nullable();
            $table->double('sub_total', 20)->nullable();
            $table->double('total', 20)->nullable();
            $table->double('balance_due', 20)->nullable();
            $table->double('amount_converted', 20)->nullable();
            $table->string('payment_receipt', 100)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('shipping_address_id')->references('id')->on('shipping_addresses')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses')->onDelete('SET NULL')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
