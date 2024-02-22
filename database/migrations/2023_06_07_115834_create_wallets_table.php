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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payment_id')->unsigned()->index()->nullable();
            $table->bigInteger('currency_id')->unsigned()->index()->nullable();
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_receipt')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status', ['pending', 'approved','rejected'])->default('pending');
            $table->longText('reason')->nullable();
            $table->double('amount_converted', 20)->nullable();
            $table->morphs('morphable');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
