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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->longText('excerpt')->nullable();
            $table->json('spec')->nullable();
            $table->json('image')->nullable();
            $table->boolean('featured')->nullable();

            $table->json('brand_logo')->nullable();
            $table->longText('brand_details')->nullable();
            
            $table->json('sale_links')->nullable();

            // Main Product pricing....
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('sale_price')->nullable();
            $table->bigInteger('qty')->default(0);
            $table->integer('low_stock')->nullable();
            $table->string('taxable')->nullable();

            $table->string('tag')->nullable();
            $table->string('up_sells')->nullable();
            $table->string('cross_sells')->nullable();

            // SEO part...
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_desc')->nullable();

            // User accessability...
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            $table->integer('status');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('label'); // e.g., Color, Size
            $table->string('label_value'); // e.g., Red, XL

            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->bigInteger('qty')->default(0);
            $table->string('sku')->unique();

            $table->timestamps();
        });

        Schema::create('products_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->noActionOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('users')->noActionOnDelete();
            $table->integer('rating')->comment('1 to 5 stars');
            $table->text('review')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->text('admin_response')->nullable();
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
        Schema::dropIfExists('products_reviews');
        Schema::dropIfExists('products_variants');
        Schema::dropIfExists('products');
    }
};
