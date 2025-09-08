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
            $table->id('order_id'); // Primary key

            // Foreign keys
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->unsignedBigInteger('courier_id')->nullable();

            // Order details
            $table->decimal('total_amount', 10, 2); 
            $table->string('current_status')->default('pending'); // pending, shipped, delivered, etc.
            $table->string('payment_method'); // cod, gcash, credit_card, etc.
            $table->string('tracking_number')->nullable();

            $table->timestamps(); // created_at & updated_at

            // Foreign key constraints
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('rider_id')
                  ->references('rider_id')->on('riders')
                  ->onDelete('set null');

            $table->foreign('courier_id')
                  ->references('courier_id')->on('couriers')
                  ->onDelete('set null');
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
