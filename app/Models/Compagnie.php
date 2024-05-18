<?php

namespace App\Models;

use App\Models\BaseModele;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Compagnie extends BaseModele
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function getFillable()
    {
        return [
            'raison_sociale',
            'contact',
            'email',
            'adresse',
            'contact_fixe',
            'country_id',
            'annee_fondation',
            'site_internet',
        ];
    }

    /**
     * The villes that belong to the compagnie.
     */
    public function villes(): BelongsToMany
    {
        return $this->belongsToMany(Ville::class);
    }

     /**
     * Get the chauffeurs for the compagnie.
     */
    public function chauffeurs(): HasMany
    {
        return $this->hasMany(Chauffeur::class);
    }
}
