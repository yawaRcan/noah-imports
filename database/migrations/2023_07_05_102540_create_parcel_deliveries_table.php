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
        Schema::create('parcel_deliveries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parcel_id')->unsigned()->index()->nullable();
            $table->bigInteger('admin_id')->unsigned()->index()->nullable();
            $table->string('reciever_name')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('signature')->nullable();
            $table->string('parcel_image')->nullable();
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_deliveries');
    }
};
