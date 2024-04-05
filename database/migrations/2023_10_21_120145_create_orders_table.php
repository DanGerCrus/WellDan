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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_order');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->on('users')->references('id');
            $table->foreign('client_id')->on('users')->references('id');
            $table->foreign('status_id')->on('orders_statuses')->references('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
