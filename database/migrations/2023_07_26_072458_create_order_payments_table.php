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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned()->index()->nullable()->constrained();
            $table->bigInteger('payment_id')->unsigned()->index()->nullable()->constrained();
            $table->double('paid_amount', 20)->nullable();
            $table->string('payment_invoice')->nullable();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('SET NULL')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
