<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = [
        'reservation_id',
        'montant_chambre',
        'montant_services',
        'montant_total',
        'statut_paiement',
        'mode_paiement',
        'date_paiement',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
