<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cette migration vérifie que toutes les tables existent
        $tables = [
            'users',
            'restaurants',
            'categories',
            'items',
            'orders',
            'order_item',
            'reservations'
        ];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                throw new Exception("Table '{$table}' does not exist!");
            }
        }

        // Vérifier quelques contraintes importantes
        $foreignKeys = [
            ['table' => 'categories', 'column' => 'restaurant_id'],
            ['table' => 'items', 'column' => 'category_id'],
            ['table' => 'orders', 'column' => 'user_id'],
            ['table' => 'orders', 'column' => 'restaurant_id'],
            ['table' => 'order_item', 'column' => 'order_id'],
            ['table' => 'order_item', 'column' => 'item_id'],
        ];

        foreach ($foreignKeys as $fk) {
            if (!Schema::hasColumn($fk['table'], $fk['column'])) {
                throw new Exception("Foreign key column '{$fk['column']}' does not exist in table '{$fk['table']}'!");
            }
        }

        // Log de succès
        Log::info('Database structure verification passed successfully!');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to rollback for verification
    }
};
