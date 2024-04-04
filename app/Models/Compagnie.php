<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Compagnie extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'raison_sociale',
        'contact',
        'email',
        'adresse',
        'contact_fixe',
        'country_id',
        'annee_fondation',
        'site_internet',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * The villes that belong to the compagnie.
     */
    public function villes(): BelongsToMany
    {
        return $this->belongsToMany(Ville::class);
    }
}
