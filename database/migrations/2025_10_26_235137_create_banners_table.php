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
Schema::create('banners', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->nullable(); // banner slug or page slug
    $table->unsignedBigInteger('page_id')->nullable(); // null means global banner
    $table->string('title');
    $table->string('image');
    $table->string('link')->nullable();
    $table->string('section')->default('main'); // e.g., 'hero', 'sidebar', 'footer'
    $table->integer('order')->default(0); // ordering in that section
    $table->boolean('active')->default(true);
    $table->timestamps();

    $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
