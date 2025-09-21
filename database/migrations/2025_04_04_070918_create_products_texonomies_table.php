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
        Schema::create('products_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        // Categories
        Schema::create('products_cats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('parent')->index();
            $table->integer('status')->default(1);
            $table->string('counts');
            $table->string('position');
            $table->timestamps();
        });

        Schema::create('products_cats_ids', function (Blueprint $table) {

            $table->string('product_id');
            $table->string('cat_id');

            $table->primary(['product_id', 'cat_id']);
        });

        // Brands ....
        Schema::create('products_brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->unsignedInteger('parent')->index();
            $table->integer('status')->default(1);
            $table->string('counts');
            $table->string('position');
            $table->timestamps();
        });

        Schema::create('products_brands_ids', function (Blueprint $table) {

            $table->string('product_id');
            $table->string('model_id');

            $table->primary(['product_id', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_brands_ids');
        Schema::dropIfExists('products_cats_ids');
        Schema::dropIfExists('products_tags');
        Schema::dropIfExists('products_cats');
        Schema::dropIfExists('products_brands');
    }
};
