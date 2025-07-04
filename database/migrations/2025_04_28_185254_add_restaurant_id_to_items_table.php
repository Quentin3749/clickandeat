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
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id')->after('id');
            $table->index('restaurant_id');
        });

        // Ajouter la contrainte de clé étrangère séparément
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('restaurant_id', 'fk_items_restaurant_id')
                  ->references('id')
                  ->on('restaurants')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('fk_items_restaurant_id');
            $table->dropColumn('restaurant_id');
        });
    }
};
