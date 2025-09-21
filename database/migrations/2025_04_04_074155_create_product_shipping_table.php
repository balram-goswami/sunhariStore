<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('shipping_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('region');
            $table->timestamps();

            $table->foreignId('zone_id')->constrained('shipping_zones')->cascadeOnDelete();
        });

        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name');
            $table->string('about');
            $table->integer('deliver')->default(0);
            $table->string('type');
            $table->string('tax');
            $table->decimal('min_amount', 10, 2)->default(0.00);
            $table->integer('discount');
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreignId('zone_id')->constrained('shipping_zones')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_regions');
        Schema::dropIfExists('shipping_methods');
        Schema::dropIfExists('shipping_zones');
    }
};
