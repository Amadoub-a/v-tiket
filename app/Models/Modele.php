<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modele extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'libelle_modele',
    ];

    /**
     * Get the vehicules for the modele.
     */
    public function vehicules(): HasMany
    {
        return $this->hasMany(Vehicule::class);
    }
}
