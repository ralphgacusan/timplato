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
            $table->decimal('subtotal', 10, 2); // before discount/shipping
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            
            $table->decimal('total_amount', 10, 2); // final after all adjustments


            $table->enum('current_status', [
                'pending',     // order placed, waiting for confirmation
                'confirmed',   // confirmed by seller/admin
                'processing',  // preparing / being packed
                'shipped',     // handed over to courier
                'delivered',   // successfully received by customer
                'completed',          // ✅ new
                'cancel_requested', // customer requested cancellation
                'cancelled',   // cancelled by user or admin
                'return_requested',   // ✅ new
                'refund_requested',
                'refund_approved',
                'return_approved',   // ✅ new
                'returned',    // returned by customer
                'refunded',    // refunded to customer
            ])->default('pending');            
            $table->string('payment_method'); // cod, gcash, credit_card, etc.
            $table->string('delivery_method'); // cod, gcash, credit_card, etc.
            $table->string('tracking_number')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamp('cancel_requested_at')->nullable();


            $table->string('return_refund_type')->nullable(); // 'return' or 'refund'
            $table->text('return_refund_reason')->nullable();
            $table->timestamp('return_refund_requested_at')->nullable();


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
