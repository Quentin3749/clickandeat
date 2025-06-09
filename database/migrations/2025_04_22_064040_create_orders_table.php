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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Client ayant passé la commande
            $table->unsignedBigInteger('restaurant_id'); // Restaurant concerné
            $table->timestamp('reservation_time')->nullable(); // Heure de réservation (si applicable)
            $table->text('notes')->nullable(); // Notes spéciales pour la commande
            $table->enum('status', ['pending', 'processing', 'ready', 'delivered', 'cancelled'])->default('pending'); // Statut de la commande
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('user_id');
            $table->index('restaurant_id');
        });

        // Ajouter les contraintes de clés étrangères après la création de la table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id', 'fk_orders_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('restaurant_id', 'fk_orders_restaurant_id')
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
        Schema::dropIfExists('orders');
    }
};
