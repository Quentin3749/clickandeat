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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Client ayant passé la commande
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade'); // Restaurant concerné
            $table->timestamp('reservation_time')->nullable(); // Heure de réservation (si applicable)
            $table->text('notes')->nullable(); // Notes spéciales pour la commande
            $table->enum('status', ['pending', 'processing', 'ready', 'delivered', 'cancelled'])->default('pending'); // Statut de la commande
            $table->timestamps();
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
