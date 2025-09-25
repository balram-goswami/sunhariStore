<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slider', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('image')->nullable(); // 👈 slider image path
            $table->boolean('status')->default(true); // true = active, false = inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slider');
    }
};
