<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Modèle représentant un item (plat, boisson, etc.)
class Item extends Model
{
    use HasFactory;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'restaurant_id',
        'category_id',
        'name',
        'description',
        'price',
        'is_available',
    ];

    /**
     * Relation : un item appartient à un restaurant.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Relation : un item appartient à une catégorie.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The orders that belong to the item.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
                    ->withPivot('quantity') // Accéder à la colonne 'quantity' de la table pivot
                    ->withTimestamps(); // Gérer les colonnes 'created_at' et 'updated_at' de la table pivot
    }
}