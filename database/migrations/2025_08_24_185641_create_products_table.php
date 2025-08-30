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
            $table->id('product_id'); // Primary key
            $table->string('name'); // Product name
            $table->text('description')->nullable(); // Product description
            $table->decimal('price', 10, 2); // Product price
            $table->integer('stock_quantity'); // Inventory level
            $table->integer('restock_level')->nullable(); // Minimum quantity before restock alert
            $table->unsignedBigInteger('category_id'); // Foreign key to categories
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraint
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
