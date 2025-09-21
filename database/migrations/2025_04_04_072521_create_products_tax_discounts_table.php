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
        Schema::create('products_taxs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->string('name');
            $table->integer('rate');
            $table->string('rate_type');
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();

            $table->timestamps();
        });

        Schema::create('products_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->string('code')->index();
            $table->text('about')->nullable();

            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('discount_type');
            $table->dateTime('expire');
            $table->decimal('minimum_amount', 10, 2)->default(0.00);
            $table->decimal('maximum_amount', 10, 2)->default(0.00);

            $table->string('products')->nullable();
            $table->string('exclude_products')->nullable();
            $table->string('product_cat')->nullable();
            $table->string('exclude_cat')->nullable();
            $table->integer('user_limit');
            $table->integer('coupon_limit');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_taxs');
        Schema::dropIfExists('products_coupons');
    }
};
