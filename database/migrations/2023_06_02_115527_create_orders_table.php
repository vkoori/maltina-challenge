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
            $table->char('invoice_id', 36)->index();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedTinyInteger('count');
            $table->double('price')->comment('per unit');
            $table->unsignedTinyInteger('consume_location');
            $table->unsignedTinyInteger('status');
            $table->timestamps();

            $table->foreign('product_id')->on('products')->references('id')->cascadeOnUpdate();
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
