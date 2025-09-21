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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('instance');

            $table->string('sku');
            $table->string('image');
            $table->integer('qty');

            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('sub_total', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            
            $table->string('taxable');
            $table->string('url');
            
            $table->timestamps();

            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
