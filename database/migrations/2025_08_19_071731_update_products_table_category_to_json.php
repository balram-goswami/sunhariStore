<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }

            // Add JSON column for multiple categories
            $table->json('category_id')->nullable()->after('brand_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_ids')) {
                $table->dropColumn('category_id');
            }

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('products_cats')
                ->noActionOnDelete()
                ->after('brand_id');
        });
    }
};

