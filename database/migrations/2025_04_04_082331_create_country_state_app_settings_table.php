<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('phonecode');
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('option_key')->unique()->index();
            $table->json('option_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
};
