<?php

namespace App\Models;

use App\Models\Genre;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\BaseModele;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicule extends BaseModele
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
            'immatriculation',
            'numero_chassis',
            'annee_fabrication',
            'nombre_place',
            'marque_id',
            'genre_id',
            'modele_id',
            'compagnie_id',
        ];
    }

    /**
     * The genre that belong to the vehicule.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * The marque that belong to the vehicule.
     */
    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class);
    }

    /**
     * The modele that belong to the vehicule.
     */
    public function modele(): BelongsTo
    {
        return $this->belongsTo(Modele::class);
    }

     /**
     * Get the departs for the vehicule.
     */
    public function departs(): HasMany
    {
        return $this->hasMany(Depart::class);
    }
}
