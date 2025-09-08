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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id'); // Primary key

            // Foreign keys
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');

            // Order item details
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2); // price at time of order

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_id')
                  ->references('order_id')->on('orders')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('product_id')->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
