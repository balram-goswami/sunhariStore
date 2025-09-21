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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('pair_id')->nullable();
            $table->string('label')->nullable();
            $table->json('attributes')->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('weight')->nullable();
            $table->json('dimensions')->nullable();
            $table->integer('attribute_count')->nullable();
            $table->boolean('is_available')->default(true);
            $table->dropUnique(['sku']);
        });

        Schema::table('product_variant_attribute_value', function (Blueprint $table) {
            
            $table->dropForeign(['product_variant_id']);

            $table->dropColumn('product_variant_id');

            $table->dropForeign(['attribute_value_id']);
            $table->string('attribute_value_id')->nullable()->change();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('attribute_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('pair_id');
            $table->dropColumn('label');
            $table->dropColumn('attributes');
            $table->dropColumn('sale_price');
            $table->dropColumn('weight');
            $table->dropColumn('dimensions');
            $table->dropColumn('attribute_count');
            $table->dropColumn('is_available');
            $table->string('sku')->unique();
        });

        Schema::table('product_variant_attribute_value', function (Blueprint $table) {
            $table->bigInteger('attribute_value_id')->change();
            $table->dropColumn('product_id');
            $table->dropColumn('attribute_id');
            $table->string('product_variant_id')->constrained()->cascadeOnDelete();
        });
    }
};
