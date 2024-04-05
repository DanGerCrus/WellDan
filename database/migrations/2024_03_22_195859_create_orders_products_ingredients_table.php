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
        Schema::create('orders_products_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('order_product_id');
            $table->unsignedInteger('count');

            $table->primary(['ingredient_id', 'order_product_id']);

            $table->foreign('ingredient_id')->on('ingredients')->references('id');
            $table->foreign('order_product_id')->on('orders_has_products')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_products_ingredients');
    }
};
