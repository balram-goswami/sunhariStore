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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });

        Schema::create('payment_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('card_id')->nullable();
            $table->string('card_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('cvv')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('customer_address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('fname');
            $table->string('lname');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('line1');
            $table->string('line2');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_cards');
        Schema::dropIfExists('customer_address');
        Schema::dropIfExists('customers');
    }
};
