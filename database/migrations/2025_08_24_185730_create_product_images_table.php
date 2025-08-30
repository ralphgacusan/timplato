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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id('image_id'); // Primary key
            $table->unsignedBigInteger('product_id'); // Foreign key to products
            $table->string('image_url'); // URL or path to the image
            $table->boolean('is_primary')->default(false); // Marks the main image
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraint
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
