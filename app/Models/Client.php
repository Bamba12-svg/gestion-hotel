<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'cin',
        'telephone',
        'email',
        'nationalite',
        'type_piece',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
