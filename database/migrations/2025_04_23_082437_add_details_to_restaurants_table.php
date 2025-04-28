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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('price_range')->nullable();
            $table->string('cuisine_type')->nullable();
            $table->string('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['description', 'address', 'price_range', 'cuisine_type', 'image_url']);
        });
    }
};
