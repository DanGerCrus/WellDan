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
        Schema::create('baskets_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('basket_id');
            $table->unsignedInteger('count');

            $table->primary(['ingredient_id', 'basket_id']);

            $table->foreign('ingredient_id')->on('ingredients')->references('id');
            $table->foreign('basket_id')->on('baskets')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baskets_ingredients');
    }
};
