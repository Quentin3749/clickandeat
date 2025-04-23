<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // Colonne `id` (clé primaire, auto-incrémentée)
            $table->string('name'); // Nom de l'article
            $table->integer('cost')->nullable(); // Coût en centimes (peut être NULL)
            $table->integer('price'); // Prix en centimes
            $table->boolean('is_active')->default(true); // Article actif ou non
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Clé étrangère vers `categories`
            $table->timestamps(); // Colonnes `created_at` et `updated_at`
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
