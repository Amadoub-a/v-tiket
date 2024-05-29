<?php

namespace App\Models;

use App\Models\Depart;
use App\Models\BaseModele;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chauffeur extends BaseModele
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function getFillable() {
       
        return [
            'name',
            'contact',
            'email',
            'adresse',
            'compagnie_id',
        ];
    }

     /**
     * The compagnie that belong to the chauffeur.
     */
    public function compagnie(): BelongsTo
    {
        return $this->belongsTo(Compagnie::class);
    }

     /**
     * Get the departs for the chauffeur.
     */
    public function departs(): HasMany
    {
        return $this->hasMany(Depart::class);
    }
}
