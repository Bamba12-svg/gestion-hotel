<?php
namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Reservation;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with('reservation.client', 'reservation.chambre')->latest()->get();
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $reservations = Reservation::with('client', 'chambre')->whereDoesntHave('facture')->get();
        return view('factures.create', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'mode_paiement'  => 'required',
        ]);

        $reservation = Reservation::with('chambre')->findOrFail($request->reservation_id);
        $nuits = max(1, \Carbon\Carbon::parse($reservation->date_arrivee)->diffInDays($reservation->date_depart));
        $montant_chambre = $nuits * $reservation->chambre->prix_nuit;
        $montant_services = $request->montant_services ?? 0;
        $montant_total = $montant_chambre + $montant_services;

        Facture::create([
            'reservation_id'   => $reservation->id,
            'montant_chambre'  => $montant_chambre,
            'montant_services' => $montant_services,
            'montant_total'    => $montant_total,
            'statut_paiement'  => $request->statut_paiement ?? 'non_paye',
            'mode_paiement'    => $request->mode_paiement,
            'date_paiement'    => $request->date_paiement,
        ]);

        return redirect('/factures')->with('success', 'Facture générée avec succès !');
    }

    public function show(Facture $facture)
    {
        $facture->load('reservation.client', 'reservation.chambre');
        return view('factures.show', compact('facture'));
    }

    public function destroy(Facture $facture)
    {
        $facture->delete();
        return redirect('/factures')->with('success', 'Facture supprimée !');
    }
}