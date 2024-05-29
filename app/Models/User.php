<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Depart;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function getFillable()
    {
        return [
            'name',
            'email',
            'password',
            'contact',
            'confirmation_token',
            'compte_actif',
            'user_connected',
            'role',
            'compagnie_id',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function getCasts()
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'=> 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the departs for the passager.
     */
    public function departs(): HasMany
    {
        return $this->hasMany(Depart::class);
    }
}
