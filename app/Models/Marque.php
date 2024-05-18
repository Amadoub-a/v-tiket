<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marque extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'libelle_marque',
    ];

    /**
     * Get the vehicules for the marque.
     */
    public function vehicules(): HasMany
    {
        return $this->hasMany(Vehicule::class);
    }
}
