<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            // Add domain_id after user_id
            $table->foreignId('domain_id')->after('user_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropForeign(['domain_id']);
            $table->dropColumn('domain_id');
        });
    }
};
