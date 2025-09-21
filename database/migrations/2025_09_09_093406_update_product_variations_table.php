<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variations', function (Blueprint $table) {
            // Remove old columns if they exist
            if (Schema::hasColumn('product_variations', 'variation_name')) {
                $table->dropColumn('variation_name');
            }
            if (Schema::hasColumn('product_variations', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('product_variations', 'length')) {
                $table->dropColumn('length');
            }
            if (Schema::hasColumn('product_variations', 'width')) {
                $table->dropColumn('width');
            }
            if (Schema::hasColumn('product_variations', 'height')) {
                $table->dropColumn('height');
            }

            // Add new columns
            if (!Schema::hasColumn('product_variations', 'attributes')) {
                $table->json('attributes')->nullable()->after('sku');
            }
            if (!Schema::hasColumn('product_variations', 'image')) {
                $table->string('image')->nullable()->after('attributes');
            }
            if (!Schema::hasColumn('product_variations', 'regular_price')) {
                $table->decimal('regular_price', 10, 2)->after('image');
            }
            if (!Schema::hasColumn('product_variations', 'sale_price')) {
                $table->decimal('sale_price', 10, 2)->nullable()->after('regular_price');
            }
            if (!Schema::hasColumn('product_variations', 'weight')) {
                $table->string('weight')->nullable()->after('sale_price');
            }
            if (!Schema::hasColumn('product_variations', 'dimensions')) {
                $table->json('dimensions')->nullable()->after('weight');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->string('variation_name')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();

            $table->dropColumn(['attributes', 'image', 'regular_price', 'sale_price', 'weight', 'dimensions']);
        });
    }
};
