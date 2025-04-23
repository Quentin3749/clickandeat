<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    
    protected $table = "restaurants";
    protected $fillable = ["name", "user_id"];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Ajouter la relation belongsTo
    }
}
