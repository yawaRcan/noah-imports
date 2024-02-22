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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('customer_no')->nullable();
            $table->string('initial_country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('lang')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('theme')->deafult(1);
            $table->string('company')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('invite_no')->deafult(0);
            $table->tinyInteger('role')->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('timezone_id')->unsigned()->index()->nullable();
            $table->foreign('timezone_id')->references('id')->on('time_zones')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('country_id')->unsigned()->index()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('cascade');
            $table->string('ip')->nullable();
            $table->rememberToken();
            $table->tinyInteger('alert')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
