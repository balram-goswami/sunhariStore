<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Drop old table if exists
        Schema::dropIfExists('product_variations');

        // Create new table
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->string('sku')->unique();

            // ensure defaults so NULL never causes error
            $table->json('attributes')->default('{}'); 
            $table->string('image')->nullable();

            $table->decimal('regular_price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();

            $table->string('weight')->nullable(); // or decimal if numeric
            $table->json('dimensions')->default('{}'); 

            $table->boolean('is_available')->default(true);
            $table->integer('stock')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
