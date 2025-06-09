<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modèle représentant un restaurant
class Restaurant extends Model
{
    use HasFactory;

    /**
     * Nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = "restaurants";

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "user_id",
        "description",
        "address",
        "price_range",
        "cuisine_type",
        "image_url",
        "opening_time",
        "closing_time",
        "primary_color",
        "logo_path"
    ];

    /**
     * Relation : un restaurant possède plusieurs catégories.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Relation : un restaurant appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Ajouter la relation belongsTo
    }

    /**
     * Relation : un restaurant possède plusieurs réservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relation : un restaurant possède plusieurs items (plats).
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Récupère la couleur principale du restaurant.
     *
     * @return string
     */
    public function getPrimaryColor()
    {
        return $this->primary_color ?? '#2563eb'; // Couleur par défaut
    }

    /**
     * Récupère l'URL du logo du restaurant.
     *
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : asset('images/default_logo.png');
    }
}
