<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depart extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicule_id',
        'chauffeur_id',
        'ville_depart_id',
        'ville_arrivee_id',
        'passager_id',
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
            'date_depart' => 'datetime',
            'date_arrivee'=> 'datetime',
            'deleted_at'=> 'datetime',
        ];
    }
}
