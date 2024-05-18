<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'libelle_country',
        'flags',
    ];

    /**
     * Get the villes for the country.
     */
    public function villes(): HasMany
    {
        return $this->hasMany(Ville::class);
    }
}
