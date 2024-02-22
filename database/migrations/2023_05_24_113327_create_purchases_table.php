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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->nullable()->constrained();
            $table->bigInteger('currency_id')->unsigned()->index()->nullable()->constrained();
            $table->bigInteger('purchase_category_id')->unsigned()->index()->nullable()->constrained();
            $table->string('product_number')->nullable();
            $table->string('name')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->double('price')->nullable(); 
            $table->string('website')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('shipping_price')->nullable();
            $table->float('tax')->nullable();
            $table->text('description')->nullable();
            $table->text('product_url')->nullable();
            $table->string('image_url')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('purchase_category_id')->references('id')->on('purchase_categories')->onDelete('SET NULL')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
