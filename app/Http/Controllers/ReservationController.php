<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Client;
use App\Models\Chambre;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['client', 'chambre'])->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $clients = Client::all();
        $chambres = Chambre::where('statut', 'libre')->get();
        return view('reservations.create', compact('clients', 'chambres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'   => 'required',
            'chambre_id'  => 'required',
            'date_arrivee' => 'required|date',
            'date_depart'  => 'required|date|after:date_arrivee',
        ]);

        $reservation = Reservation::create($request->all());

        // Marquer la chambre comme occupée
        Chambre::find($request->chambre_id)->update(['statut' => 'occupee']);

        return redirect('/reservations')->with('success', 'Réservation créée avec succès !');
    }

    public function edit(Reservation $reservation)
    {
        $clients = Client::all();
        $chambres = Chambre::all();
        return view('reservations.edit', compact('reservation', 'clients', 'chambres'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'client_id'    => 'required',
            'chambre_id'   => 'required',
            'date_arrivee' => 'required|date',
            'date_depart'  => 'required|date|after:date_arrivee',
            'statut'       => 'required', 
        ]);

        // Si checkout, libérer la chambre
        if ($request->statut == 'checkout') {
            Chambre::find($reservation->chambre_id)->update(['statut' => 'libre']);
        }

        $reservation->update($request->all());
        return redirect('/reservations')->with('success', 'Réservation mise à jour !');
    }

    public function destroy(Reservation $reservation)
    {
        // Libérer la chambre
        Chambre::find($reservation->chambre_id)->update(['statut' => 'libre']);
        $reservation->delete();
        return redirect('/reservations')->with('success', 'Réservation supprimée !');
    }
}