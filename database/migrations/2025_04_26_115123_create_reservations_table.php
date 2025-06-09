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
            // Ajout des champs pour personnalisation graphique
            $table->string('primary_color')->nullable();
            $table->string('logo_path')->nullable();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->time('time');
            $table->integer('guests');
            $table->string('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('restaurant_id');
            $table->index('user_id');
        });

        // Ajouter les contraintes de clés étrangères après la création de la table
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('restaurant_id', 'fk_reservations_restaurant_id')
                  ->references('id')
                  ->on('restaurants')
                  ->onDelete('cascade');

            $table->foreign('user_id', 'fk_reservations_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('primary_color');
            $table->dropColumn('logo_path');
        });
    }
};
