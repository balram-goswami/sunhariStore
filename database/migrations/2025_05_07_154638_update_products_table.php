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
        //
        Schema::table('products', function (Blueprint $table) {
            $table->integer('low_stock')->nullable()->change();
            $table->string('sku')->nullable()->change();
            $table->decimal('price', 10, 2)->nullable()->change();
            $table->decimal('sale_price', 10, 2)->nullable()->change();
            $table->integer('qty')->nullable()->change();
            $table->boolean('has_variants')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->change();
            $table->decimal('price', 10, 2)->default(0.00)->change();
            $table->decimal('sale_price', 10, 2)->nullable()->change(); 
            $table->bigInteger('qty')->default(0)->change();
            $table->integer('low_stock')->nullable(false)->change();
            $table->string('taxable')->nullable(false)->change(); 
        });
    }
};
