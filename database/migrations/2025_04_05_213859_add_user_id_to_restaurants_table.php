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
            $table->unsignedBigInteger('user_id')->nullable(); // Ajouter la colonne user_id
            $table->foreign('user_id')->references('id')->on('users'); // Définir la clé étrangère
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Supprimer la clé étrangère
            $table->dropColumn('user_id'); // Supprimer la colonne user_id
        });
    }
};