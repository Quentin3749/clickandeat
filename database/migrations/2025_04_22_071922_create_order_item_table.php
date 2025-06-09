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
        Schema::create('order_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity')->unsigned()->default(1);
            $table->timestamps();

            // Empêcher les doublons d'items dans une même commande
            $table->unique(['order_id', 'item_id']);

            // Index pour améliorer les performances
            $table->index('order_id');
            $table->index('item_id');
        });

        // Ajouter les contraintes de clés étrangères après la création de la table
        Schema::table('order_item', function (Blueprint $table) {
            $table->foreign('order_id', 'fk_order_item_order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');

            $table->foreign('item_id', 'fk_order_item_item_id')
                  ->references('id')
                  ->on('items')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
