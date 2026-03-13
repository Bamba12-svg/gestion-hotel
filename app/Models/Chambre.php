<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    protected $fillable = [
        'numero',
        'type',
        'prix_nuit',
        'statut',
        'capacite',
        'description',
        'image',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
}
