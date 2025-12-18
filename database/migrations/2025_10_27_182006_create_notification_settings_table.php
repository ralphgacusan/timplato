<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id('setting_id');
            $table->string('key')->unique(); // e.g. "order_confirmed"
            $table->string('label'); // e.g. "Order Confirmed Notification"
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
