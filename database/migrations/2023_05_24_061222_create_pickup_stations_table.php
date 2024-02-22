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
        Schema::create('pickup_stations', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('initial_country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('branch_id')->unsigned()->index()->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL')->onUpdate('cascade'); 
            $table->bigInteger('country_id')->unsigned()->index()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_stations');
    }
};
