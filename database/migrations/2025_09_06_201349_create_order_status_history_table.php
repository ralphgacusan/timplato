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
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id('history_id'); // Primary key

            // Foreign key
            $table->unsignedBigInteger('order_id');

            // Status tracking
            $table->string('status');   // e.g. pending, shipped, delivered, cancelled
            $table->string('location')->nullable(); // Optional: where the update happened

            $table->timestamp('updated_at')->useCurrent(); // Last update timestamp

            // Add created_at if you want to track record creation
            $table->timestamp('created_at')->useCurrent();

            // Foreign key constraint
            $table->foreign('order_id')
                  ->references('order_id')->on('orders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_history');
    }
};
