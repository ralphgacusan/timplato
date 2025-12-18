<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();        // e.g. ALDEN50
            $table->enum('discount_type', ['fixed', 'percentage']); // fixed or percentage
            $table->decimal('discount_value', 8, 2); // e.g. 50.00 or 0.10
            $table->string('description')->nullable(); // e.g. "10% off total"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
