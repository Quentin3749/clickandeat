<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'reservation_time',
        'notes',
        'status',
    ];

    protected $casts = [
        'reservation_time' => 'datetime',
    ];

    /**
     * Get the user that placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the restaurant for the order.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * The items that belong to the order.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
                    ->withPivot('quantity') // Accéder à la colonne 'quantity' de la table pivot
                    ->withTimestamps(); // Gérer les colonnes 'created_at' et 'updated_at' de la table pivot
    }
}