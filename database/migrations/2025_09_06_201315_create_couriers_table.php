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
     Schema::create('couriers', function (Blueprint $table) {
            $table->id('courier_id'); // Primary key
            $table->string('name');   // Courier company name
            $table->string('phone')->nullable(); // Contact phone (nullable in case not provided)
            $table->string('tracking_url')->nullable(); // Base URL for tracking shipments
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
