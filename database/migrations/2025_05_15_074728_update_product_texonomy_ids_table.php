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
        Schema::table('products_brands', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('customers')->noActionOnDelete();
        });

        Schema::table('products_cats', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('customers')->noActionOnDelete();
        });

        Schema::table('products_tags', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('customers')->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_brands', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
        Schema::table('products_cats', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
        Schema::table('products_tags', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
    }
};
