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
         Schema::create('reviews', function (Blueprint $table) {
        $table->id('review_id'); // Primary key
        $table->unsignedBigInteger('product_id'); // FK to products
        $table->unsignedBigInteger('user_id');    // FK to users
        $table->tinyInteger('rating')->unsigned(); // 1-5 stars
        $table->text('comment')->nullable();
        $table->timestamps();

        // Foreign keys
        $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
