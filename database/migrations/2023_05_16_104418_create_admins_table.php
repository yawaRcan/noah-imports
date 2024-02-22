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
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); 
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('initial_country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('lang')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('theme')->default(1);
            $table->string('timezone')->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('timezone_id')->unsigned()->index()->nullable()->constrained();
            $table->foreign('timezone_id')->references('id')->on('time_zones')->onDelete('SET NULL')->onUpdate('cascade');
            $table->bigInteger('branch_id')->unsigned()->index()->nullable()->constrained();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('SET NULL')->onUpdate('cascade'); 
            $table->bigInteger('country_id')->unsigned()->index()->nullable()->constrained();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
