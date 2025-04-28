<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;
use App\Models\User;

// Modèle représentant une réservation effectuée par un utilisateur
class Reservation extends Model
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
        'date',
        'time',
        'guests',
    ];

    /**
     * Relation : une réservation appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : une réservation appartient à un restaurant.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
