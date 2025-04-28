<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Modèle représentant une catégorie de restaurant ou d'item
class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'restaurant_id',
    ];

    /**
     * Relation : une catégorie appartient à un restaurant.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Relation : une catégorie possède plusieurs items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}