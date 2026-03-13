<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'client_id',
        'chambre_id',
        'date_arrivee',
        'date_depart',
        'statut',
        'observations',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function chambre()
    {
        return $this->belongsTo(Chambre::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    public function getNuitsAttribute()
    {
        return \Carbon\Carbon::parse($this->date_arrivee)
                ->diffInDays($this->date_depart);
    }

    public function getMontantTotalAttribute()
    {
        return $this->nuits * $this->chambre->prix_nuit;
    }
}
