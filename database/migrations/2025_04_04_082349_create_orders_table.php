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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->string('ip');
            $table->integer('billing_id');
            $table->integer('shipping_id');
            $table->string('note');
            $table->string('payment_type');
            $table->string('transaction_id');
            $table->string('charge_tax');
            $table->string('discount');
            $table->string('coupon');

            $table->integer('status')->default(0);
            $table->boolean('shipped')->default(0);
            $table->boolean('seen')->default(0);

            $table->decimal('discount_total', 10, 2)->default(0.00);
            $table->decimal('net_sub_total', 10, 2)->default(0.00);
            $table->decimal('net_tax_amount', 10, 2)->default(0.00);
            $table->decimal('net_discount_amount', 10, 2)->default(0.00);
            $table->decimal('net_shipping_amount', 10, 2)->default(0.00);
            $table->decimal('net_shipping_tax', 10, 2)->default(0.00);
            $table->decimal('net_fee_amount', 10, 2)->default(0.00);
            $table->decimal('net_total', 10, 2)->default(0.00);

            $table->softDeletes();
            $table->timestamps();

        });


        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->unsignedInteger('product_id')->index();
            $table->string('name');
            $table->string('sku');

            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('qty', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('tax_total', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('fee_title');
            $table->decimal('amount', 10, 2)->default(0.00);
        });

        Schema::create('order_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->noActionOnDelete();
            $table->integer('type');
            $table->string('note');
            $table->integer('status');

            $table->timestamps();
        });

        Schema::create('order_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->decimal('refund_amount', 10, 2)->default(0.00);
            $table->string('reason');
            $table->integer('restock');
            $table->integer('refund_by');

            $table->timestamps();
        });

        Schema::create('order_refund_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refund_id')->constrained('order_refunds')->cascadeOnDelete();
            $table->integer('item_type');
            $table->integer('resource_id')->index();
            $table->integer('item_id')->index();
            $table->integer('qty');
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('amount', 10, 2)->default(0.00);

            $table->timestamps();
        });

        Schema::create('order_shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('name');
            $table->integer('method');
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('charge', 10, 2)->default(0.00);
            $table->decimal('amount', 10, 2)->default(0.00);

            $table->timestamps();
        });

        Schema::create('order_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('tax_type');
            $table->string('type')->index();
            $table->integer('tax_id')->index();
            $table->integer('item_id')->index();
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('amount', 10, 2)->default(0.00);

            $table->timestamps();
        });

        Schema::create('order_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->noActionOnDelete();
            $table->string('coupon');
            $table->decimal('amount', 10, 2)->default(0.00);

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
        Schema::dropIfExists('order_refund_items');
        Schema::dropIfExists('order_refunds');
        Schema::dropIfExists('order_notes');
        Schema::dropIfExists('order_coupons');
        Schema::dropIfExists('order_shippings');
        Schema::dropIfExists('order_taxes');
        Schema::dropIfExists('order_fees');
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('orders');
    }
};
