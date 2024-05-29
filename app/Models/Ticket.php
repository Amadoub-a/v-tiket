<?php

namespace App\Models;

use App\Models\BaseModele;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends BaseModele
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
            'numero_ticket',
            'numero_siege',
            'depart_id',
            'passager_id',
        ];
    }

     /**
     * The depart that belong to the ticket.
     */
    public function depart(): BelongsTo
    {
        return $this->belongsTo(Depart::class);
    }

    /**
     * The passager that belong to the ticket. 
     */
    public function passager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
