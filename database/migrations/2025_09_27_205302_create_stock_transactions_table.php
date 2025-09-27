<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id('stock_transaction_id');
            
            // Match the foreign key to the correct column in products
            $table->unsignedBigInteger('product_id');

            $table->string('type'); // 'add' or 'deduct'
            $table->integer('quantity');
            $table->string('performed_by'); // store full name of user

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_id')
                ->references('product_id') // use your actual PK
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
