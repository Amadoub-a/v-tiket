<?php

namespace App\Models;

use App\Models\BaseModele;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Depart extends BaseModele
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
            'vehicule_id',
            'chauffeur_id',
            'ville_depart_id',
            'ville_arrivee_id',
            'place_occupee',
        ];
    }

     /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function getCasts()
    {
        return [
            'date_depart' => 'datetime',
            'date_arrivee'=> 'datetime',
        ];
    }

     /**
     * The vehicule that belong to the depart.
     */
    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * The chauffeur that belong to the depart.
     */
    public function chauffeur(): BelongsTo
    {
        return $this->belongsTo(Chauffeur::class);
    }

    /**
     * The ville_depart that belong to the depart.
     */
    public function ville_depart(): BelongsTo
    {
        return $this->belongsTo(Ville::class);
    }

    /**
     * The ville_arrivee that belong to the depart.
     */
    public function ville_arrivee(): BelongsTo
    {
        return $this->belongsTo(Ville::class);
    }
}
