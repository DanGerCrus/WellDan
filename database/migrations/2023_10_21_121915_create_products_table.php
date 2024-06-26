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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->text('description');
            $table->unsignedInteger('price');
            $table->unsignedFloat('kkal');
            $table->unsignedBigInteger('category_id');
            $table->boolean('no_ingredients')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->on('products_categories')->references('id');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
