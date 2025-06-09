<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Modèle représentant une commande passée par un utilisateur
class Order extends Model
{
    use HasFactory;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'reservation_time',
        'notes',
        'status',
    ];

    /**
     * Les attributs pouvant être castés en types spécifiques.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reservation_time' => 'datetime',
    ];

    /**
     * Relation : une commande appartient à un utilisateur.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : une commande appartient à un restaurant.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Les items qui appartiennent à la commande.
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
                    ->withPivot('quantity') // Accéder à la colonne 'quantity' de la table pivot
                    ->withTimestamps(); // Gérer les colonnes 'created_at' et 'updated_at' de la table pivot
    }
}