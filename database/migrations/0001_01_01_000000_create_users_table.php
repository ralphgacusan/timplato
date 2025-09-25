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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('first_name'); // First name
            $table->string('last_name');  // Last name
            $table->string('email')->unique(); // Unique email login
            $table->string('password'); // Hashed password
            $table->string('phone')->nullable(); // Contact number
            $table->string('profile_picture_path')->nullable(); // Profile picture (optional)
            $table->enum('role', ['user', 'admin']); // User role
            $table->enum('gender', ['male', 'female', 'prefer_not_to_say'])->nullable(); // Gender           
            $table->date('date_of_birth')->nullable(); // Date of birth
            $table->timestamps(); // created_at and updated_at
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
