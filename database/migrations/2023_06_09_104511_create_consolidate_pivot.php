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
        Schema::create('consolidate_pivot', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('consolidate_id')->unsigned()->index()->nullable();
            $table->bigInteger('parcel_id')->unsigned()->index()->nullable(); 
            $table->timestamps();
            $table->foreign('consolidate_id')->references('id')->on('consolidates')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consolidate_pivot');
    }
};
