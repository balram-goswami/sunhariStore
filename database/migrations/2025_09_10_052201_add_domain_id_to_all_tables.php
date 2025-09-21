<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'api_permissions',
            'art_form',
            'customers',
            'orders',
            'pages',
            'products_brands',
            'products_cats',
            'products_coupons',
            'products_reviews',
            'products_tags',
            'products_taxs',
            'queries',
            'shipping_methods',
            'shipping_regions',
            'shipping_zones',
            'tickets',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'domain_id')) {
                    $table->unsignedBigInteger('domain_id')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'api_permissions',
            'art_form',
            'customers',
            'orders',
            'pages',
            'products_brands',
            'products_cats',
            'products_coupons',
            'products_reviews',
            'products_tags',
            'products_taxs',
            'queries',
            'shipping_methods',
            'shipping_regions',
            'shipping_zones',
            'tickets',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'domain_id')) {
                    $table->dropColumn('domain_id');
                }
            });
        }
    }
};
