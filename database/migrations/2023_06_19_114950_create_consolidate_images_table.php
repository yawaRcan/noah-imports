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
        Schema::create('consolidate_images', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('hash_name')->nullable();
            $table->string('size')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('consolidate_id')->unsigned()->index()->nullable();
            $table->foreign('consolidate_id')->references('id')->on('consolidates')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consolidate_images');
    }
};
