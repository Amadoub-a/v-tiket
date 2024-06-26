<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ville extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'libelle_ville',
        'country_id',
    ];

    /**
     * The compagnies that belong to the ville.
     */
    public function compagnies(): BelongsToMany
    {
        return $this->belongsToMany(Compagnie::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
