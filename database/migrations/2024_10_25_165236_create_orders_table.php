<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('shipping_address');
            $table->string('township', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->date('order_date')->default(now());
            $table->enum('payment_type', ['CASH_ON_DELIVERY', 'BANK_TRANSFER'])->default('CASH_ON_DELIVERY');
            $table->enum('delivery_type', ['STORE_PICKUP', 'YANGON', 'OTHERS'])->default('STORE_PICKUP');
            $table->float('total_price');
            $table->date('delivery_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
