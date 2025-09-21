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
        Schema::table('shoppingcart', function (Blueprint $table) {
            // naye columns
            $table->unsignedBigInteger('product_id')->nullable()->after('content');
            $table->unsignedBigInteger('customer_id')->nullable()->after('product_id');
            $table->unsignedBigInteger('variant_id')->nullable()->after('customer_id');
            $table->unsignedBigInteger('domain_id')->nullable()->after('variant_id');

            // foreign keys
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shoppingcart', function (Blueprint $table) {
            // pehle foreign keys drop karni hongi
            $table->dropForeign(['product_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['variant_id']);
            $table->dropForeign(['domain_id']);

            // phir columns drop
            $table->dropColumn(['product_id', 'customer_id', 'variant_id', 'domain_id']);
        });
    }
};
