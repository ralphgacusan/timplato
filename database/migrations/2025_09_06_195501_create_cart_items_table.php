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
        Schema::create('cart_items', function (Blueprint $table) {
        $table->id('cart_item_id'); // Primary key

        // Foreign keys as unsigned big integers
        $table->unsignedBigInteger('cart_id');
        $table->unsignedBigInteger('product_id');

        // Foreign key constraints
        $table->foreign('cart_id')
              ->references('cart_id')
              ->on('carts')
              ->onDelete('cascade');

        $table->foreign('product_id')
              ->references('product_id')
              ->on('products')
              ->onDelete('cascade');
              
        $table->integer('quantity')->default(1); // Quantity of product in cart
        $table->timestamps(); // created_at & updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
