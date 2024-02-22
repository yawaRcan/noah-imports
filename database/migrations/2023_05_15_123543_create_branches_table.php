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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('branch_key')->nullable(); 
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address')->nullable();
            $table->string('address_line')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('currency_id')->unsigned()->index()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL')->onUpdate('cascade'); 
            $table->bigInteger('country_id')->unsigned()->index()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('cascade');
            $table->string('initial_country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->integer('pickup_fee')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
