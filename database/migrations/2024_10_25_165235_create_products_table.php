<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->decimal('price', 10, 2);
            $table->integer('discount_percent')->default(0)->nullable();
            $table->string('description', 255);
            $table->text('detail')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('image_1', 100);
            $table->string('image_2', 100);
            $table->integer('stock')->default(0)->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
