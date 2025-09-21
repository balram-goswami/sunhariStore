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
        Schema::table('products', function (Blueprint $table) {
            $table->string('tag')->nullable()->change();
            $table->string('up_sells')->nullable()->change();
            $table->string('cross_sells')->nullable()->change();

            $table->string('seo_title')->nullable()->change();
            $table->string('seo_keywords')->nullable()->change();
            $table->string('seo_desc')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('tag');
            $table->string('up_sells');
            $table->string('cross_sells');

            // SEO part...
            $table->string('seo_title');
            $table->string('seo_keywords');
            $table->string('seo_desc');
        });
    }
};
