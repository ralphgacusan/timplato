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
Schema::create('pages', function (Blueprint $table) {
    $table->id();
    $table->string('slug'); // e.g., 'contact-us'
    $table->string('title');
    $table->text('content');
    $table->string('section')->default('main'); // e.g., 'hero', 'contact', 'info'
    $table->integer('order')->default(0); // ordering in that section
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
